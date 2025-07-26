<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssignmentRequest;
use App\Http\Requests\UpdateStoreAssignRequest;
use App\Models\Assignment;
use App\Models\Guest;
use App\Models\Room;
use App\Models\Therapist;
use App\Models\Treatment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', today()->toDateString()); 

        $rooms = Room::orderByRaw("name = 'Reflexology' DESC")
            ->orderBy('name')
            ->get();
        $assignments = Assignment::with(['guests.treatment', 'guests.therapist', 'room'])
            ->where('date', $date)
            ->get();

            
        // Create time slots (every 15 minutes from 09:00 to 22:00)
        $start = Carbon::createFromTime(9, 0);
        $end = Carbon::createFromTime(22, 0);
        $timeSlots = [];
        while ($start <= $end) {
            $timeSlots[] = $start->format('H:i');
            $start->addMinutes(15);
        }

        // Group assignments by room and time
        $assignmentMap = [];
        foreach ($rooms as $room) {
            foreach ($assignments->where('room_id', $room->id) as $assignment) {
                $guests = $assignment->guests;

                // Find earliest start and max duration among guests
                $dateStart = $this->toYMD($assignment->date);
                // $dateStart = Carbon::parse($assignment->date)->format('Y-m-d');
                $startTime = Carbon::parse($dateStart . ' ' . $assignment->start_time);
                $maxDuration = $guests->max('duration_in_min');
                $endTime = $startTime->copy()->addMinutes($maxDuration);
                $rowspan = ceil($maxDuration / 15);

                // Find the nearest time slot before or equal to start time
                $matchedSlot = collect($timeSlots)
                ->map(fn($t) => Carbon::createFromFormat('H:i', $t)->setDateFrom($startTime))
                ->filter(fn($t) => $t->lte($startTime))
                ->sortDesc()
                ->first();

            if ($matchedSlot) {
                $slotStr = $matchedSlot->format('H:i');

                if (!isset($assignmentMap[$slotStr][$room->id])) {
                    $assignmentMap[$slotStr][$room->id] = [];
                }

                $assignmentMap[$slotStr][$room->id][] = [
                    'assignment_id' => $assignment->id,
                    'rowspan' => $rowspan,
                    'guests' => $guests,
                    'start_time' => $assignment->start_time,
                ];
            }
            }
        }

        return view('assignments.index', compact('rooms', 'timeSlots', 'assignmentMap', 'date','assignments'));
    }

    public function create(Request $request)
    {
        
        $room = Room::findOrFail($request->room_id);
        $therapists = Therapist::orderBy('name')->get();
        $treatments = Treatment::orderBy('name')->get();

        return view('assignments.create', compact('room', 'therapists', 'treatments'));
    }

    public function store(StoreAssignmentRequest $request)
    {
        $room = Room::findOrFail($request->room_id);
        $guestCount = count($request->guests);
        $startTime = $request->start_time;
        $date = $this->toYMD($request->date);

        $maxDuration = $this->getMaxDuration($request->guests);

        $startNew = Carbon::parse("$date $startTime");
        $endNew = $startNew->copy()->addMinutes($maxDuration);

        //Cek Jam Operasional
        if (!$this->isWithinOperatingHours($date,$startTime, $endNew)) {
            return back()->withErrors(['start_time' => 'The Store Open at 09:00 AM and Closes at 10:00 PM.'])->withInput();
        }

        // Cek Kapasitas Kamar
        if ($this->exceedsRoomCapacity($room, $guestCount)) {
            return back()->withErrors([
                'guests' => "This room can only accommodate up to {$room->bed_count} guests."
            ])->withInput();
        }
        
        // Cek Availability Kamar
        if (!$this->isRoomAvailable($room, $startNew, $endNew, $date, $guestCount)) {
            return back()->withErrors(['start_time' => 'Room is already full during this time.'])->withInput();
        }

       // Cek Availability Therapist
       foreach ($request->guests as $index => $guest) {
            if (!$this->isTherapistAvailable($guest['therapist_id'], $date, $startNew, (int)$guest['duration_in_min'])) {
                return back()->withErrors([
                    "guests.$index.therapist_id" => "Therapist is not available at this time."
                ])->withInput();
            }
        }

        // Save to database inside transaction
        DB::transaction(function () use ($request, $room, $date, $startTime) {
            $assignment = Assignment::create([
                'room_id' => $room->id,
                'trx_no' => $request->trx_no, 
                'date' => $date,
                'start_time' => $startTime,
                'remark' => $request->remark,
            ]);

            foreach ($request->guests as $guest) {
                Guest::create([
                    'assignment_id' => $assignment->id,
                    'name' => $guest['name'],
                    'treatment_id' => $guest['treatment_id'],
                    'therapist_id' => $guest['therapist_id'],
                    'duration_in_min' => (int) $guest['duration_in_min'],
                ]);
            }
        });

        return redirect()->route('assignments.index');
    }

    public function show($id)
    {
        //
        $assignment = Assignment::withTrashed()
        ->with(['room', 'guests.treatment', 'guests.therapist'])
        ->findOrFail($id);

        $startTime = Carbon::parse($assignment->start_time);
        $maxDuration = $assignment->guests->max('duration_in_min') ?? 0;
        $finishTime = $startTime->copy()->addMinutes($maxDuration)->format('H:i');

        return view('assignments.show', compact('assignment', 'finishTime'));
    }

    public function edit(Assignment $assignment)
    {
        //
        $assignment->load('guests');
        $therapists = Therapist::orderBy('name')->get();
        $treatments = Treatment::orderBy('name')->get();
        $roomId = Room::findOrFail($assignment->room_id);
        $rooms = Room::orderBy('name')->get();
        
        return view('assignments.edit', compact('roomId','assignment', 'rooms', 'therapists', 'treatments'));
    }

    public function update(UpdateStoreAssignRequest $request, Assignment $assignment)
{
    $room = Room::findOrFail($request->room_id);
    $guestCount = count($request->guests);
    $date = $this->toYMD($request->date);
    $startTime = $request->start_time;

    $maxDuration = $this->getMaxDuration($request->guests);

    $startNew = Carbon::parse("$date $startTime");
    $endNew = $startNew->copy()->addMinutes($maxDuration);

    // Cek Jam Operasional
    if (!$this->isWithinOperatingHours($date,$startTime, $endNew)) {
        return back()->withErrors(['start_time' => 'The Store Open at 09:00 AM and Closes at 10:00 PM.'])->withInput();
    }

    // Cek Kapasitas Kamar
    if ($this->exceedsRoomCapacity($room, $guestCount)) {
        return back()->withErrors([
            'guests' => "This room can only accommodate up to {$room->bed_count} guests."
        ])->withInput();
    }

    // Cek Availability Kamar (exclude current assignment)
    if (!$this->isRoomAvailable($room, $startNew, $endNew, $date, $guestCount, $assignment->id)) {
        return back()->withErrors(['start_time' => 'Room is already full during this time.'])->withInput();
    }

    // Cek Availability Therapist
    foreach ($request->guests as $index => $guest) {
        if (!$this->isTherapistAvailable($guest['therapist_id'], $date, $startNew, (int)$guest['duration_in_min'], $assignment->id)) {
            return back()->withErrors([
                "guests.$index.therapist_id" => "Therapist is not available at this time."
            ])->withInput();
        }
    }

    // Update in transaction
    DB::transaction(function () use ($request, $assignment, $room, $date, $startTime) {
        $assignment->update([
            'room_id' => $room->id,
            'trx_no' => $request->trx_no,
            'date' => $date,
            'start_time' => $startTime,
            'remark' => $request->remark,
        ]);

        // Remove old guests
        $assignment->guests()->forceDelete();

        // Insert updated guest list
        foreach ($request->guests as $guest) {
            Guest::create([
                'assignment_id' => $assignment->id,
                'name' => $guest['name'],
                'treatment_id' => $guest['treatment_id'],
                'therapist_id' => $guest['therapist_id'],
                'duration_in_min' => (int) $guest['duration_in_min'],
            ]);
        }
    });

    return redirect()->route('assignments.index');
}

    public function destroy(Assignment $assignment)
    {
        $assignmentDate = Carbon::parse((string) $assignment->date);
        // $assignmentDate = Carbon::parse($assignment->date);
        $today = Carbon::today();

        // Disallow deleting if the assignment date is before today
        if ($assignmentDate->lt($today)) {
            return redirect()
                ->route('assignments.show', $assignment)
                ->with('error', 'You cannot delete assignments from the past.');
        }

        DB::transaction(function() use($assignment){
            $assignment->delete();
        });

        return redirect()->route('assignments.index');
    }

    

    public function cancelledAssignments()
    {
        $assignments = Assignment::onlyTrashed()
            ->with(['room', 'guests.treatment', 'guests.therapist'])
            ->orderBy('date', 'desc') // optional: order latest first
            ->paginate(10); // or ->get() if you don’t want pagination

        return view('assignments.cancelled', compact('assignments'));
    }

    public function toYMD($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }

    public function isWithinOperatingHours($date, $startTime, $endNew)
        {
            $start = Carbon::parse("$date $startTime");
            $end = Carbon::make($endNew); // already a Carbon instance in your code

            $openTime = Carbon::parse("$date 09:00");
            $closeTime = Carbon::parse("$date 22:00");

            return $start->gte($openTime) && $end->lte($closeTime);
        }


    public function getMaxDuration(array $guests)
    {
        return (int) collect($guests)->max(fn($g) => (int) $g['duration_in_min']);
    }

    public function exceedsRoomCapacity(Room $room, int $guestCount): bool
    {
        return $guestCount > $room->bed_count;
    }

    public function isRoomAvailable($room, $start, $end, $date, $newGuestCount, $ignoreAssignmentId = null)
    {
        $assignments = $room->assignments()->where('date', $date)->when($ignoreAssignmentId, fn($q) => $q->where('id', '!=', $ignoreAssignmentId))->with('guests')->get();

        if (in_array($room->type, ['Single', 'Double'])) {
            foreach ($assignments as $assignment) {
                $existingDate = $this->toYMD($assignment->date);
                $existingStart = Carbon::parse("{$existingDate} {$assignment->start_time}");
                $existingEnd = $existingStart->copy()->addMinutes(
                    $assignment->guests->max('duration_in_min') ?? 0
                );
                if ($start < $existingEnd && $end > $existingStart) return false;
            }
        } elseif ($room->type === 'Sharing') {
            $overlapCount = 0;
            foreach ($assignments as $assignment) {
                foreach ($assignment->guests as $guest) {
                    $guestDate = $this->toYMD($assignment->date);
                    $guestStart = Carbon::parse("{$guestDate} {$assignment->start_time}");
                    $guestEnd = $guestStart->copy()->addMinutes($guest->duration_in_min);
                    if ($start < $guestEnd && $end > $guestStart) $overlapCount++;
                }
            }
            if ($overlapCount + $newGuestCount > $room->bed_count) return false;
        }
        return true;
    }

    public function isTherapistAvailable($therapistId, $date, $start, $duration, $ignoreAssignmentId = null)
    {
        $end = $start->copy()->addMinutes($duration);
    
        $guests = Guest::where('therapist_id', $therapistId)
            ->whereHas('assignment', function ($q) use ($date, $ignoreAssignmentId) {
                $q->where('date', $date);
                if ($ignoreAssignmentId) $q->where('id', '!=', $ignoreAssignmentId);
            })
            ->with('assignment')
            ->get();
    
        foreach ($guests as $guest) {
            $existingDate = $this->toYMD($guest->assignment->date);
            $existingStart = Carbon::parse("{$existingDate} {$guest->assignment->start_time}");
            $existingEnd = $existingStart->copy()->addMinutes($guest->duration_in_min);
    
            if ($start < $existingEnd && $end > $existingStart) return false;
        }
        return true;
    }


}

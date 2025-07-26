<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTherapistRequest;
use App\Http\Requests\UpdateTherapistRequest;
use App\Models\Assignment;
use App\Models\Therapist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TherapistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date = $request->input('date', today()->toDateString()); 
        // Only available therapists
        $therapists = Therapist::where('is_available', true)
            ->orderBy('name')
            ->get();

        // Get all assignments for the day
        $assignments = Assignment::with(['guests.treatment', 'guests.therapist', 'room'])
            ->where('date', $date)
            ->get();

        // Time slots from 09:00 to 22:00 in 15-minute intervals
        $start = Carbon::createFromTime(9, 0);
        $end = Carbon::createFromTime(22, 0);
        $timeSlots = [];
        while ($start <= $end) {
            $timeSlots[] = $start->format('H:i');
            $start->addMinutes(15);
        }

        // Map assignments by therapist and time slot
        $assignmentMap = [];

        foreach ($therapists as $therapist) {
            foreach ($assignments as $assignment) {
                foreach ($assignment->guests as $guest) {
                    if ($guest->therapist_id !== $therapist->id) {
                        continue; // skip if this guest isn't assigned to this therapist
                    }

                    $dateStart = Carbon::parse($assignment->date)->format('Y-m-d');
                    $startTime = Carbon::parse($dateStart . ' ' . $assignment->start_time);
                    $duration = $guest->duration_in_min ?? 60;
                    $endTime = $startTime->copy()->addMinutes($duration);
                    $rowspan = ceil($duration / 15);

                    // Find slot that matches or is just before start
                    $matchedSlot = collect($timeSlots)
                        ->map(fn($t) => Carbon::createFromFormat('H:i', $t)->setDateFrom($startTime))
                        ->filter(fn($t) => $t->lte($startTime))
                        ->sortDesc()
                        ->first();

                    if ($matchedSlot) {
                        $slotStr = $matchedSlot->format('H:i');

                        if (!isset($assignmentMap[$slotStr][$therapist->id])) {
                            $assignmentMap[$slotStr][$therapist->id] = [];
                        }

                        $assignmentMap[$slotStr][$therapist->id][] = [
                            'assignment_id' => $assignment->id,
                            'rowspan' => $rowspan,
                            'guest' => $guest,
                            'room' => $assignment->room,
                            'start_time' => $assignment->start_time,
                        ];
                    }
                }
            }
        }

        return view('therapists.index', compact('therapists', 'timeSlots', 'assignmentMap', 'date'));
    }


    public function therapistslist()
    {
        //
        $therapists = Therapist::orderBy('name', 'asc')->paginate(20);
        return view('therapists.therapistslist', compact('therapists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('therapists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTherapistRequest $request)
    {
        //
        DB::transaction(function () use ($request) {
            
            $validated = $request->validated();

            if($request->hasfile('image')){
                $imagePath = $request->file('image')->store('images', 'public');
                $validated['image'] = $imagePath;
            }

            $newTherapist = Therapist::create($validated);
        });

        return redirect()->route('therapists.therapistslist');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Therapist $therapist)
    {
        //

        $date = $request->input('date'); // optional, nullable
        $guestsQuery = $therapist->guests()->with(['treatment', 'assignment']);

        if ($date) {
            $guestsQuery->whereHas('assignment', function ($q) use ($date) {
                $q->where('date', $date);
            });
        }

        $guests = $guestsQuery->paginate(10);

        return view('therapists.show', compact('therapist', 'guests', 'date'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Therapist $therapist)
    {
        //
        return view('therapists.edit', compact('therapist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTherapistRequest $request, Therapist $therapist)
    {
        //
        DB::transaction(function () use ($request, $therapist) {
            
            $validated = $request->validated();

            if($request->hasfile('image')){
                $imagePath = $request->file('image')->store('images', 'public');
                $validated['image'] = $imagePath;
            }

            $therapist->update($validated);
        });

        return redirect()->route('therapists.therapistslist');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Therapist $therapist)
    {
        //
        DB::transaction(function() use($therapist){
            $therapist->delete();
        });

        return redirect()->route('therapists.therapistslist');
    }

    public function toggle(Therapist $therapist)
{
    $therapist->is_available = !$therapist->is_available;
    $therapist->save();

    return response()->json([
        'success' => true,
        'is_available' => $therapist->is_available
    ]);
}




}

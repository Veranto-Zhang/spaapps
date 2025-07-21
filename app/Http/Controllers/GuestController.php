<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestRequest;
use App\Models\Assignment;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $date = $request->input('date', today()->toDateString());

        $guests = Guest::with(['assignment', 'treatment', 'therapist'])
            ->whereHas('assignment', function ($query) use ($date) {
                $query->where('date', $date);
            })
            ->orderBy('assignment_id')
            ->orderBy('id') // optional: within the same assignment
            ->paginate(10); // 👈 change this number as needed

        return view('guests.index', compact('guests', 'date'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('guests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuestRequest $request)
    {
        //
        DB::transaction(function () use ($request) {
            
            $validated = $request->validated();

            $newGuest = Guest::create($validated);
        });

        return redirect()->route('guests.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guest $guest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guest $guest)
    {
        //
        return view('guests.edit', compact('guest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreGuestRequest $request, Guest $guest)
    {
        //
        DB::transaction(function() use ($request, $guest) {
            
            $validated = $request->validated();

            $guest->update($validated);
        });

        return redirect()->route('guests.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guest $guest)
    {
        //
        DB::transaction(function() use($guest){
            $guest->delete();
        });

        return redirect()->route('guests.index');
    }
}

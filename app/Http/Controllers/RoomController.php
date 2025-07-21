<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $rooms = Room::orderBy('id', 'asc')->paginate(20);
        $rooms = Room::orderByRaw("name = 'Reflexology' DESC")
        ->orderBy('name')
        ->paginate(20);

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        //
        DB::transaction(function () use ($request) {
            
            $validated = $request->validated();

            $newRoom = Room::create($validated);
        });

        return redirect()->route('rooms.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
        return view('rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRoomRequest $request, Room $room)
    {
        //
        DB::transaction(function () use ($request, $room) {
            
            $validated = $request->validated();


            $room->update($validated);
        });

        return redirect()->route('rooms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
        DB::transaction(function() use($room){
            $room->delete();
        });

        return redirect()->route('rooms.index');
    }
}

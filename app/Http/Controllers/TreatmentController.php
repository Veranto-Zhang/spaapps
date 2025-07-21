<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTreatmentRequest;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $treatments = Treatment::orderBy('id', 'asc')->paginate(10);
        return view('treatments.index', compact('treatments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('treatments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTreatmentRequest $request)
    {
        //
        DB::transaction(function () use ($request) {
            
            $validated = $request->validated();

            $newTreatment = Treatment::create($validated);
        });

        return redirect()->route('treatments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Treatment $treatment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Treatment $treatment)
    {
        //
        return view('treatments.edit', compact('treatment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTreatmentRequest $request, Treatment $treatment)
    {
        //
        DB::transaction(function () use ($request, $treatment) {
            
            $validated = $request->validated();

            $treatment->update($validated);
        });

        return redirect()->route('treatments.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Treatment $treatment)
    {
        //
        DB::transaction(function() use($treatment){
            $treatment->delete();
        });

        return redirect()->route('treatments.index');
    }
}

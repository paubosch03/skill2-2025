<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Athletes;
use Inertia\Inertia;
use App\Models\Sports;

class AthletesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Athlete', [
            'athletes' => Athletes::with('sport')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('AddAthlete');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birth_date' => 'required|max:255',
            'country' => 'required|max:255'
        ]);

        Athletes::create($validate);
        return redirect()->route('Athlete.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $athlete = Athletes::find($id);
        return Inertia::render('ShowAthlete', [
            'athlete' => $athlete,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $athlete = Athletes::find($id);
        return Inertia::render('EditAthlete', [
            'athlete' => $athlete,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birth_date' => 'required|max:255',
            'country' => 'required|max:255'
        ]);
        $athlete = Athletes::find($id);
        $athlete->update($validate);
        return redirect()->route('Athlete.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Athletes $athlete)
    {
        $athlete->delete();
        return redirect()->route('Athlete.index');
    }
}

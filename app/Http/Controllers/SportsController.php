<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sports;
use Inertia\Inertia;

class SportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('sport', [
            'sports' => Sports::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('AddSport');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
            'players_per_team' => 'required|max:255',
            'category' => 'required|max:255'
        ]);

    
        Sports::create($validate);
        return redirect()->route('sport.index');
           
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sport = Sports::find($id);
        return Inertia::render('ShowSport', [
            'sport' => $sport,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sport = Sports::find($id);
        return Inertia::render('EditSport', [
            'sport' => $sport,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
            'players_per_team' => 'required|max:255',
            'category' => 'required|max:255'
        ]);

        $sport = Sports::find($id);
        $sport->update($validate);
        return redirect()->route('sport.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sports $sport)
    {
        $sport->delete();
        return redirect()->route('sport.index');
    }
}

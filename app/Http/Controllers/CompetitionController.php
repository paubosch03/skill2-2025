<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Sports;

class CompetitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Competition', [
            'competitions' => Competition::with('sport')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('AddCompetition');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
            'start_date' => 'required|max:255',
            'end_date' => 'required|max:255',
            'location' => 'required|max:255',
            'prize' => 'required|max:255'
        ]);

        Competition::create($validate);
        return redirect()->route('Competition.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $competition = Competition::find($id);
        return Inertia::render('ShowCompetition', [
            'competition' => $competition
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $competition = Competition::find($id);
        return Inertia::render('EditCompetition', [
            'competition' => $competition
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
            'start_date' => 'required|max:255',
            'end_date' => 'required|max:255',
            'location' => 'required|max:255',
            'prize' => 'required|max:255'
        ]);
        $competition = Competition::find($id);
        $competition->update($validate);
        return redirect()->route('Competition.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $competition = Competition::find($id);
        if ($competition) {
            $competition->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}

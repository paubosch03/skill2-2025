<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Houses;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $houses = Houses::all();
        if (request()->expectsJson()) {
            return response()->json(['houses' => $houses]);
        }
        return Inertia::render('House');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $house = new Houses();
        $house->address = $request->address;
        $house->city = $request->city;
        $house->zip_code = $request->zip_code;
        $house->country = $request->country;

        $house->save();

        return response()->json($house);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $house = Houses::find($id);
        if ($house) {
            $house->address = $request->address;
            $house->city = $request->city;
            $house->zip_code = $request->zip_code;
            $house->country = $request->country;

            $house->save();
            return response()->json($house);
        } else {
            return response()->json(['message' => 'Casa no actualizado exitosamente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $house = Houses::find($id);
        return response()->json($house);
    }

    public function getHouses()
    {
        $houses = Houses::all();
        return response()->json($houses);
    }
}

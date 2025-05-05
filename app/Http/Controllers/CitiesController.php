<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cities;
use Inertia\Inertia;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = Cities::all();
        if (request()->expectsJson()) {
            return response()->json(['cities' => $cities]);
        }

        return Inertia::render('City', ['cities' => $cities]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $city = new Cities();
        $city->name = $request->name;
        $city->country = $request->country;
        $city->population = $request->population;

        $city->save();

        return response()->json($city);
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
        $city = Cities::find($id);
        if ($city) {
            $city->name = $request->name;
            $city->country = $request->country;
            $city->population = $request->population;
            $city->save();
            return response()->json($city);
        } else {
            return response()->json(['message' => 'city not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $city = Cities::find($id);
        if ($city) {
            $city->delete();
            return response()->json(['message' => 'Ciudad eliminada exitosamente']);
        }
        return response()->json(['message' => 'Ciudad no encontrada']);
    }

    public function getAllCities()
    {
        $cities = Cities::all();
        return response()->json($cities);
    }
}

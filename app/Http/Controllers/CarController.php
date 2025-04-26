<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cars;
use Inertia\Inertia;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Cars::all();

        if (request()->expectsJson()) {
            return response()->json(['cars' => $cars]);
        }

        return Inertia::render('Car', ['cars' => $cars]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('carCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $car = new Cars();
        $car->make = $request->make;
        $car->model = $request->model;
        $car->year = $request->year;
        $car->color = $request->color;
        $car->price = $request->price;
        $car->mileage = $request->mileage;

        $car->save();

        return response()->json(['message' => 'Car created succeful']);
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
        $car = Cars::find($id);
        if ($car) {
            $car->make = $request->make;
            $car->model = $request->model;
            $car->year = $request->year;
            $car->color = $request->color;
            $car->price = $request->price;
            $car->mileage = $request->mileage;

            $car->save();
            return response()->json(['message' => 'Coche actualizado exitosamente.']);
        } else {
            return response()->json(['message' => 'Coche no actualizado exitosamente.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Cars::find($id);
        if ($car) {
            $car->delete();
            return response()->json(['message' => 'coche eliminado exitosamente.']);
        } else {
            return response()->json(['message' => 'Coche no encontrado.'], 404);
        }
    }
}

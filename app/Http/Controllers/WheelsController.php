<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wheels;
use Inertia\Inertia;
use Inertia\Response;

class WheelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wheels = Wheels::all();

        if (request()->expectsJson()) {
            return response()->json(['wheels' => $wheels]);
        }

        return Inertia::render('Wheels', ['wheels' => $wheels]);
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
        $wheel = new Wheels();
        $wheel->brand = $request->brand;
        $wheel->price = $request->price;
        $wheel->stock = $request->stock;

        $wheel->save();

        return response()->json($wheel);
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
        $wheel = Wheels::find($id);
        if ($wheel) {
            $wheel->brand = $request->brand;
            $wheel->price = $request->price;
            $wheel->stock = $request->stock;

            $wheel->save();
            return response()->json($wheel);
        } else {
            return response()->json(['message' => 'wheel not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wheel = Wheels::find($id);
        if($wheel){
            $wheel->delete();
            return response()->json(['message' => 'Rueda eliminada exitosamente']);
        }
        return response()->json(['message' => 'Rueda no encontrada']);
    }

    public function getWheels()
    {
        $wheels = Wheels::all();
        return response()->json($wheels);
    }
}

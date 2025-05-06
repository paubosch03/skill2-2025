<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bikes;
use Inertia\Inertia;

class BikesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bikes = Bikes::with('houses:id,address')->get();

        // dd($bikes);

        if (request()->expectsJson()) {
            return response()->json(['bikes' => $bikes]);
        }

        return Inertia::render('Bikes', ['bikes' => $bikes]);
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
        $bike = new Bikes();
        $bike->brand = $request->brand;
        $bike->model = $request->model;
        $bike->type = $request->type;
        $bike->color = $request->color;
        $bike->frame_material = $request->frame_material;
        $bike->speeds = $request->speeds;
        $bike->price = $request->price;

        $bike->save();

        return response()->json($bike);
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
        $bike = Bikes::find($id);
        if ($bike) {
            $bike->brand = $request->brand;
            $bike->model = $request->model;
            $bike->type = $request->type;
            $bike->color = $request->color;
            $bike->frame_material = $request->frame_material;
            $bike->speeds = $request->speeds;
            $bike->price = $request->price;

            $bike->save();

            return response()->json($bike);
        }

        return response()->json(['message' => 'bike not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bike = Bikes::find($id);
        if ($bike) {
            $bike->delete();
            return response()->json(['message' => 'Bicicleta eliminada exitosamente']);
        }
        return response()->json(['message' => 'Bicicleta no encontrada']);
    }

    public function getAllBikes()
    {
        $bikes = Bikes::all();
        return response()->json($bikes);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clothes;
use Inertia\Inertia;

class ClothesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clothes = Clothes::all();

        if (request()->expectsJson()) {
            return response()->json(['clothes' => $clothes]);
        }

        return Inertia::render('Clothes', ['clothes' => $clothes]);
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
        $clothe = new Clothes();
        $clothe->type = $request->type;
        $clothe->brand = $request->brand;
        $clothe->color = $request->color;
        $clothe->size = $request->size;
        $clothe->price = $request->price;
        $clothe->material = $request->material;
        $clothe->gender = $request->gender;

        $clothe->save();

        return response()->json($clothe);
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
        $clothe = Clothes::find($id);
        if ($clothe) {
            $clothe->type = $request->type;
            $clothe->brand = $request->brand;
            $clothe->color = $request->color;
            $clothe->size = $request->size;
            $clothe->price = $request->price;
            $clothe->material = $request->material;
            $clothe->gender = $request->gender;

            $clothe->save();
            return response()->json($clothe);
        } else {
            return response()->json(['message' => 'Clothe not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $clothe = Clothes::find($id);
        if ($clothe) {
            $clothe->delete();
            return response()->json(['message' => 'Ropa eliminada exitosamente']);
        }
        return response()->json(['message' => 'Ropa no encontrada']);
    }

    public function getAllClothes()
    {
        $clothes = Clothes::all();
        return response()->json($clothes);
    }
}

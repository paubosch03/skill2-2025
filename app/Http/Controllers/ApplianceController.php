<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Appliances;

class ApplianceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appliances = Appliances::all();
        if (request()->expectsJson()) {
            return response()->json($appliances); // Sin envolver en array
        }
        return Inertia::render('Appliance');
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
        $appliance = new Appliances();
        $appliance->name = $request->name;
        $appliance->brand = $request->brand;
        $appliance->price = $request->price;
        $appliance->power = $request->power;

        return response()->json($appliance);
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
        $appliance = Appliances::find($id);
        if ($appliance) {
            $appliance->name = $request->name;
            $appliance->brand = $request->brand;
            $appliance->price = $request->price;
            $appliance->power = $request->power;
            $appliance->save();
            return response()->json($appliance);
        }
        return response()->json(['message' => 'Appliance not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appliance = Appliances::find($id);
        if ($appliance) {
            $appliance->delete();
            return response()->json(['message' => 'Electrodomesticos eliminado exitosamente.']);
        }else{
            return response()->json(['message' => 'Electrodomesticos no encontrado.']);
        }
    }
    public function getAppliances()
    {
        $appliances = Appliances::all();
        return response()->json($appliances);
    }
}

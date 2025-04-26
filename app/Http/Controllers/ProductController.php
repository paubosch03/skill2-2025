<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        if (request()->expectsJson()) {
            return response()->json(['products' => $products]);
        }
        return Inertia::render('Producto', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ProductoCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category = $request->category;

        $product->save();
        return response()->json(['message' => 'Producto creado exitosamente.']);
    }
    /**
     * Display the specified resource.
     */
    public function show(Product $product) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product) {}
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->category = $request->category;

            $product->save();
            return response()->json(['message' => 'Producto actualizado exitosamente.']);
        } else {
            return response()->json(['message' => 'Producto no encontrado.'], 404);
        }
    }


    public function destroy(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json(['message' => 'Producto eliminado exitosamente.']);
        } else {
            return response()->json(['message' => 'Producto no encontrado.'], 404);
        }
    }
}

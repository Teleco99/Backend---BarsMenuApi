<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtiene solo los productos que pertenecen al admin autenticado
        $products = Admin::findOrFail(Auth::id())->products()->get();
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // Siempre debe tener un admin_id para referenciar el producto
        $request->validate([
            'name' => 'required|string|max:255',
            'admin_id' => 'required|integer|numeric',
            'menu_id' => 'sometimes|required|integer|numeric',
            'description' => 'string',
            'price' => 'string',
            'allergens' => 'array', 
        ]);

        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Verificar si el producto pertenece al admin autenticado
        if (!$product->admin()->where('id', Auth::id())->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product = Product::findOrFail($id);

        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Verificar si el producto pertenece al admin autenticado
        if (!$product->admin()->where('id', Auth::id())->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'admin_id' => 'required|integer|numeric',
            'menu_id' => 'sometimes|required|integer|numeric',
            'description' => 'string',
            'price' => 'string',
            'allergens' => 'array',
        ]);

        $product->update([
            'name' => $request->name ?? $product->name,
            'admin_id' => $request->admin_id ?? $product->admin_id,
            'menu_id' => $request->menu_id ?? $product->menu_id,
            'description' => $request->description ?? $product->description,
            'price' => $request->price ?? $product->price,
            'allergens' => $request->allergens ?? $product->allergens,
        ]);
        
        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Verificar si el producto pertenece al admin autenticado
        if (!$product->admin()->where('id', Auth::id())->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product->delete();
        
        return response()->json(null, 204);
    }
}

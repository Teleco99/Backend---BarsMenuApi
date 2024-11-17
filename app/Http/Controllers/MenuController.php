<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Admin;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MenuResource;

class MenuController extends Controller
{
    /**
     * Muestra menus de un restaurante (dado el id de su admin)
     */
    public function index($idAdmin)
    {
        // Obtener admin 
        $admin = Admin::findOrFail($idAdmin);
        
        // Obtiene solo los menús que pertenecen al admin
        $menus = $admin->menus()->get();
        
        return response()->json([
            'data' => MenuResource::collection($menus)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'products' => 'array', 
        ]);

        // Creamos el menú
        $menu = new Menu([
            'name' => $request->name,
        ]);

        // Asociamos admin con menu
        $admin = Admin::findOrFail(Auth::id());
        $admin->menus()->save($menu);

        // Asociamos el menu con los productos si están presentes
        if ($request->has('products')) {
            foreach ($request->products as $productData) {
                // Rellena nuevo producto con datos
                $product = new Product();
                $product->fill(array_diff_key($productData, ['id' => '']));
                
                $menu->products()->save($product);
            }
        }
        
        return new MenuResource($menu);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Verifica si el menú pertenece al admin autenticado
        if (!Admin::findOrFail(Auth::id())->menus()->where('id', $id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $menu = Menu::findOrFail($id);

        return new MenuResource($menu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'products' => 'array', // Validar la entrada de productos
        ]);

        // Verificar si el menú pertenece al admin autenticado
        if (!Admin::findOrFail(Auth::id())->menus()->where('id', $menu->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Actualizamos el menú primero
        $menu->update([
            'name' => $request->name ?? $menu->name,
        ]);

        // Luego actualizamos los productos si están presentes
        if ($request->has('products')) {
            foreach ($request->products as $productData) {
                // Comprobar si el producto tiene un ID (existe en la base de datos)
                if (isset($productData['id'])) {
                    // Si existe, lo buscamos y actualizamos
                    $product = $menu->products()->find($productData['id']);
                    if ($product) {
                        $product->update(array_diff_key($productData, ['id' => '']));
                    }
                } else {
                    // Si no tiene ID, es un producto nuevo
                    $newProduct = new Product(array_diff_key($productData, ['id' => '']));
                    $menu->products()->save($newProduct);
                }
            }
        }
        
        return new MenuResource($menu);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // Verificar si el menú pertenece al admin autenticado
        if (!Admin::findOrFail(Auth::id())->menus()->where('id', $menu->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        // Elimina los productos del menu
        $menu->products()->delete();

        // Elimina el menu (y las asociaciones de productos a este menu)
        $menu->delete();

        return response()->json(null, 204);
    }
}

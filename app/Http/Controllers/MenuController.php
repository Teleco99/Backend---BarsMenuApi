<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MenuResource;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtiene solo los menús que pertenecen al admin autenticado
        $menus = Admin::findOrFail(Auth::id())->menus()->get();
        //var_dump($menus);
        return MenuResource::collection($menus);
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
        $menu = Menu::create([
            'name' => $request->name,
        ]);

        // Asociamos los productos si están presentes
        if ($request->has('products')) {
            $menu->products()->sync($request->products); 
        }

        // Creamos una nueva asociación para el menu y para sus productos
        $admin = Admin::findOrFail(Auth::id());
        $admin->menus()->attach($menu->id);
        $admin->products()->attach($request->products);
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
            'name' => 'sometimes|required|string|max:255',
            'products' => 'sometimes|array', // Validar la entrada de productos
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
            $menu->products()->sync($request->products);  // Actualiza las relaciones
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

        // Elimina el menu (y las asociaciones de productos a este menu)
        $menu->delete();

        return response()->json(null);
    }
}

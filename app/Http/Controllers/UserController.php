<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Mostrar datos de usuario autentificado
        return new User(Auth::user());
    }

    public function store(Request $request)
    {
        $post = User::create($request->all());
        return response()->json($post, 201);
    }

    public function show($id)
    {
        //return User::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        // Actualizar usuario autentificado
        $user = Auth::user();
        $user->update($request->all());
        return response()->json($post, 200);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}

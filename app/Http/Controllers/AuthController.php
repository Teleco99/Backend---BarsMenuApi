<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Registro de usuarios
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token');

        return ['token' => $token->plainTextToken];
    }

    // Inicio de sesión
    public function login(Request $request)
    {
        // Validar datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Intentar login
        if (!Auth::attempt($request->only('email', 'password'))) {
            return ['message' => 'Invalid login credentials'];
        }

        // Obtener usuario
        $user = Auth::user();

        // Crear token de sesión
        $token = $user->createToken('auth_token');

        return ['token' => $token->plainTextToken];
    }

    // Cerrar sesión 
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return ['token' => 'deleted'];
    }
}

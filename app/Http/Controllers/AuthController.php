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
        /*
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

        return ['token' => $token->plainTextToken];*/
        return ['message' => 'acceso denegado'];
    }

    // Inicio de sesión de usuarios admin
    public function login(Request $request)
    {
        // Validar datos del formulario
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Intentar login de usuario admin
        if (!Auth::guard('admin')->attempt($credentials)) {
            return ['message' => 'Invalid login credentials'];
        }

        // Obtener admin
        $admin = Auth::guard('admin')->user();

        // Crear token de sesión
        $token = $admin->createToken('admin_token', ['admin']);

        return [
            'token' => $token->plainTextToken,
            'idAdmin' => $admin->id
        ];
    }

    // Cerrar sesión 
    public function logout(Request $request)
    {
        // Obtener admin
        $admin = Auth::user();
        
        // Borrar tokens
        $admin->tokens()->delete();

        return [
            'token' => 'deleted',
            'idAdmin' => $admin->id        
        ];
    }
}

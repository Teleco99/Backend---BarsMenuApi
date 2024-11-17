<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Comprueba si el usuario está autenticado y es admin
        if ($request->user()->tokenCan('admin')) {
            return $next($request);
        }

        // Si no es admin, devuelve un error de no autorizado
        return response()->json(['message' => 'Unauthorized']);
    }
}

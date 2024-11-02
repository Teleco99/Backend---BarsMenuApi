<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ImageController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckOwnerMiddleware;

/* apiResource: 
	GET	/ -> index
	POST / -> store
	GET	/{id} -> show
	PUT/PATCH /{id} -> update
	DELETE /{id} -> delete
*/

// Rutas de Autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
	->middleware('auth:sanctum');

// Rutas de Usuario
Route::apiResource('/users', UserController::class)
	->only(['index', 'update', 'delete'])
	->middleware('auth:sanctum');

// Rutas de Admin 
Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
	// Rutas de Menu y Product
    Route::apiResource('/products', ProductController::class)->except(['index']);
    Route::apiResource('/menus', MenuController::class);

    // Rutas de Imagen
    Route::get('/image/{idProduct}', [ImageController::class, 'getUserImage']);
    Route::post('/image', [ImageController::class, 'uploadImage']);
});







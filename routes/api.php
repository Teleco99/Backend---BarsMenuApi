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

// Rutas publicas
Route::get('/menus/{idAdmin}', [MenuController::class, 'index']);
Route::get('/image/{idAdmin}/{model}/{idModel}', [ImageController::class, 'getUserImage']);

// Rutas de Autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
	->middleware(['auth:sanctum', AdminMiddleware::class]);

// Rutas de Usuario
Route::apiResource('/users', UserController::class)
	->only(['index', 'update', 'delete'])
	->middleware('auth:sanctum');

// Rutas de Admin 
Route::middleware(['auth:sanctum', AdminMiddleware::class])->group(function () {
	// Rutas de Menu y Product
    Route::apiResource('/products', ProductController::class)->except(['index']);
    Route::apiResource('/menus', MenuController::class)->except(['index']);

    // Rutas de Imagen
    Route::post('/image/{model}', [ImageController::class, 'uploadImage']);
    Route::delete('/image/{idModel}/{model}', [ImageController::class, 'deleteImage']);
});







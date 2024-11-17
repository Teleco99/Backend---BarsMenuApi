<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return file_get_contents(public_path('wasm/index.html'));
})->where('any', '^(?!api).*'); // Esto excluye rutas que empiezan con "api"

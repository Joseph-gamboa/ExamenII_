<?php

use App\Http\Controllers\controllerListas;
use Illuminate\Support\Facades\Route;

Route::get('/', [controllerListas::class, 'index'])->name('home');

// Index de listas (de tu compañero). Si él ya tiene su propia ruta, usa la suya y borra esta.
Route::get('/listas', [controllerListas::class, 'index'])->name('listas.index');

// ===== GESTIÓN PÚBLICA (Estudiante B) =====
// Van al FINAL: /{token} atrapa cualquier URL de un solo segmento.
// Sin middleware 'auth' -> se accede sin iniciar sesión.
Route::put('/{token}/items/{item}', [controllerListas::class, 'update'])
    ->where('token', '[A-Za-z0-9_-]+')
    ->name('lista.items.update');

Route::get('/{token}', [controllerListas::class, 'publica'])
    ->where('token', '[A-Za-z0-9_-]+')
    ->name('publica.index');
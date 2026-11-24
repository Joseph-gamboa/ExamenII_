
<?php

use App\Http\Controllers\controllerListas;
use App\Http\Controllers\ControllerItems;
use Illuminate\Support\Facades\Route;

// INICIO
Route::get('/', [controllerListas::class, 'index'])->name('home');

// LISTAS
Route::get('/listas', [controllerListas::class, 'index'])
    ->name('listas.index');

// CREAR LISTA
Route::get('/listas/create', [controllerListas::class, 'create'])
    ->name('listas.create');

Route::post('/listas', [controllerListas::class, 'store'])
    ->name('listas.store');

// EDITAR LISTA
Route::get('/listas/{id}/edit', [controllerListas::class, 'edit'])
    ->name('listas.edit');

// ACTUALIZAR LISTA
Route::put('/listas/{id}', [controllerListas::class, 'actualizar'])
    ->name('listas.update');

// ELIMINAR LISTA
Route::delete('/listas/{id}', [controllerListas::class, 'eliminar'])
    ->name('listas.destroy');

// GESTIÓN PÚBLICA DE ITEMS
Route::put('/{token}/items/{item}', [ControllerItems::class, 'update'])
    ->where('token', '[A-Za-z0-9_-]+')
    ->name('lista.items.update');

// LISTA PÚBLICA
// Esta ruta debe quedar al final.
Route::get('/{token}', [controllerListas::class, 'publica'])
    ->where('token', '[A-Za-z0-9_-]+')
    ->name('publica.index');

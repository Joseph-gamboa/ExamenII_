
<?php

use App\Http\Controllers\controllerListas;
use App\Http\Controllers\ControllerAuth;
use Illuminate\Support\Facades\Route;

// Página principal
Route::get('/', function () {
    return redirect()->route('listas.index');
});

// Login
Route::middleware('guest')->group(function () {

    Route::get('/login', function () {
        return view('login.index');
    })->name('login');

    // Redireccionar a Google
    Route::get('/auth/google', [ControllerAuth::class, 'redirectGoogle'])
        ->name('google');

    // Respuesta de Google
    Route::get('/auth/google/callback', [ControllerAuth::class, 'callbackGoogle'])
        ->name('google.callback');

});

// Cerrar sesión
Route::post('/logout', [ControllerAuth::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Gestión privada de listas
Route::middleware('auth')->group(function () {

    Route::get('/listas', [controllerListas::class, 'index'])
        ->name('listas.index');

    Route::get('/listas/crear', [controllerListas::class, 'create'])
        ->name('listas.create');

    Route::post('/listas', [controllerListas::class, 'store'])
        ->name('listas.store');

    Route::get('/listas/{lista}/editar', [controllerListas::class, 'edit'])
        ->name('listas.edit');

    Route::put('/listas/{lista}', [controllerListas::class, 'actualizar'])
        ->name('listas.update');

    Route::delete('/listas/{lista}', [controllerListas::class, 'destroy'])
        ->name('listas.destroy');

});

use App\Http\Controllers\ControllerItems;

// Gestión pública de listas

Route::put('/{token}/items/{item}', [ControllerItems::class, 'update'])
    ->where('token', '[A-Za-z0-9]+')
    ->name('lista.items.update');

Route::get('/{token}', [controllerListas::class, 'publica'])
    ->where('token', '[A-Za-z0-9]+')
    ->name('publica.index');    
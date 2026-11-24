<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ControllerAuth extends Controller
{
      // Redireccionar a Google
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Recibir respuesta de Google
    public function callbackGoogle(Request $request)
    {
        $googleUser = Socialite::driver('google')->user();

        // Buscar usuario por Google ID
        $usuario = User::where('google_id', $googleUser->getId())
            ->first();

        // Si no existe, verificar si el correo ya está registrado
        if (!$usuario) {

            if (User::where('email', $googleUser->getEmail())->exists()) {

                return redirect()->route('login')->withErrors([
                    'google' => 'Este correo ya tiene una cuenta registrada.'
                ]);

            }

            // Registrar nuevo usuario
            $usuario = new User();

            $usuario->nombre = $googleUser->getName();
            $usuario->email = $googleUser->getEmail();
            $usuario->google_id = $googleUser->getId();

            $usuario->save();
        }

        // Iniciar sesión
        Auth::login($usuario);

        $request->session()->regenerate();

        return redirect()->route('listas.index');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
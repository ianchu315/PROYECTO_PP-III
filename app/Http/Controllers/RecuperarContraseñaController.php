<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RecuperarContraseñaController extends Controller
{
    public function index()
    {
        return view('autenticacion.recuperar');
    }

    public function enviarMail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuarios,email',
        ]);

        $status = Password::broker('usuarios')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Se ha enviado un enlace a tu correo para restablecer la contraseña.')
            : back()->withErrors(['email' => __($status)]);
    }

    public function mostrarFormularioReset($token)
    {
        return view('autenticacion.reset', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:usuarios,email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        $status = Password::broker('usuarios')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($usuario, $password) {
                $usuario->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('bolsadetrabajo.iniciar-sesion')->with('success', 'Tu contraseña ha sido restablecida correctamente.')
            : back()->withErrors(['email' => [__($status)]]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Flasher\Laravel\Facade\Flasher;


// Gestiona el inicio y cierre de sesión de usuarios, valida credenciales, muestra mensajes de error o éxito con toasts, y redirige según si el perfil está completo.

class InicioSesionController extends Controller
{
    public function index()
    {
        return view('autenticacion.iniciar_sesion');
    }


    public function procesar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Es obligatorio ingresar email',
            'email.email' => 'Debes ingresar un email válido',
            'password.required' => 'Es obligatorio ingresar contraseña',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                Flasher::addError($error);
            }
            return back()->withInput();
        }

        $credenciales = $request->only('email', 'password');

        if (Auth::guard('usuarios')->attempt($credenciales)) {
            $request->session()->regenerate();
            $usuario = Auth::guard('usuarios')->user();

            // Comprobar estado explícito: pendiente / rechazado / aprobado
            $estado = $usuario->estado ?? null;
            if ($estado === 'pendiente') {
                Auth::guard('usuarios')->logout();
                Flasher::addError('Tu cuenta está pendiente de aprobación.');
                return back()->withInput();
            }

            if ($estado === 'rechazado') {
                Auth::guard('usuarios')->logout();
                Flasher::addError('Tu cuenta fue rechazada por el administrador.');
                return back()->withInput();
            }

            if ($estado === 'inactivo') {
                Auth::guard('usuarios')->logout();
                Flasher::addError('Tu cuenta fue dada de baja. Contactate con el administrador si creés que es un error.');
                return back()->withInput();
            }

            if (!$usuario->perfil_completado) {
                Flasher::addSuccess('Completa tu perfil');
            //    return redirect()->route('bolsadetrabajo.perfil.editar');
            }

            Flasher::addSuccess('¡Sesión iniciada correctamente!');

            $redirectTo = $request->input('redirect') ?: $request->query('redirect');
            if ($redirectTo) {
                return redirect($redirectTo);
            }

            return redirect()->route('bolsadetrabajo.panel');
        }

        Flasher::addError('Credenciales incorrectas.');
        return back()->withInput();
    }


    public function logout(Request $request)
    {
        Auth::guard('usuarios')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        

        Flasher::addSuccess('Sesión cerrada.');
        return redirect('/bolsadetrabajo/inicio');
    }
}

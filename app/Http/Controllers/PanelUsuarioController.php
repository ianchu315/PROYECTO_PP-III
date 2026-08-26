<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

// Página a la que cae cualquier usuario logueado de Bolsa de Trabajo justo
// después de iniciar sesión: saludo + navbar según su rol. Es el "dashboard
// nuevo" pedido, separado de bolsadetrabajo/home (que sigue existiendo tal
// cual estaba) y de mesasfront.
class PanelUsuarioController extends Controller
{
    public function index()
    {
        $usuario = Auth::guard('usuarios')->user();

        return view('panel.index', compact('usuario'));
    }
}

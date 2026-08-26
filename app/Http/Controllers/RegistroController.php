<?php
namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Flasher\Laravel\Facade\Flasher;


//Controlador que gestiona el registro de usuarios: valida los datos con mensajes personalizados, muestra errores mediante toasts, crea el usuario con contraseña hasheada, muestra un toast de éxito y redirige al login. 
class RegistroController extends Controller
{
    public function index()
    {
        $carreras = \App\Models\Carrera::orderBy('descripcion')->get();
        return view('autenticacion.registro', compact('carreras'));
    }

    public function store(Request $request)
    {
    $request->merge(['dni' => preg_replace('/\D/', '', $request->dni)]);
    $validator = Validator::make($request->all(), [
        'nombre'     => 'required|string|max:255',
        'apellido'   => 'required|string|max:255',
        'dni'        => 'required|digits:8|unique:usuarios,dni',
        'email'      => 'required|email|unique:usuarios,email',
        'password'   => 'required|min:8',
        'carrera_id' => 'required|exists:carreras,id',
    ], [
        'nombre.required'     => 'Es obligatorio ingresar nombre',
        'apellido.required'   => 'Es obligatorio ingresar apellido',
        'email.required'      => 'Es obligatorio ingresar email',
        'email.email'         => 'Debes ingresar un email válido',
        'email.unique'        => 'Este email ya está registrado',
        'password.required'   => 'Es obligatorio ingresar contraseña',
        'password.min'        => 'La contraseña debe tener al menos 8 caracteres',
        'carrera_id.required' => 'Seleccioná la carrera que estás cursando',
        'carrera_id.exists'   => 'La carrera seleccionada no es válida',
        'dni.required'        => 'Es obligatorio ingresar el documento',
        'dni.digits'          => 'El documento debe tener exactamnte 8 dígitos',
        'dni.unique'          => 'Ya existe una cuenta registrada con ese documento'
    ]);

    if ($validator->fails()) {
        foreach ($validator->errors()->all() as $error) {
            Flasher::addError($error);
        }
        return back()->withInput();
    }

    $usuario = Usuario::create([
        'nombre'            => $request->nombre,
        'apellido'          => $request->apellido,
        'email'             => $request->email,
        'dni'               => $request->dni,
        'password'          => Hash::make($request->password),
        'rol'               => 'usuario', // por defecto; el superadmin decide alumno/profesor al aprobar
        'carrera_id'        => $request->carrera_id,
        'perfil_completado' => false,
        'aprobado'          => false,
        'estado'            => 'pendiente',
    ]);

    Flasher::addSuccess('Cuenta creada correctamente.');
    return redirect()->route('bolsadetrabajo.iniciar-sesion');
    }
}
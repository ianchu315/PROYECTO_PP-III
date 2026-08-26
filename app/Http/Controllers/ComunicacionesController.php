<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Part\TextPart;
use Flasher\Laravel\Facade\Flasher;


// Controlador que permite buscar alumnos por nombre, apellido o email, obtener alumnos por carrera y enviar correos masivos a destinatarios específicos o a todos los alumnos de una carrera, evitando duplicados.

class ComunicacionesController extends Controller
{
     public function index()
    {
        return view('admin_comunicaciones');
    }

    public function buscarAlumnos(Request $request)
    {
    $search = $request->get('q');

    $alumnos = Usuario::where('email', 'LIKE', "%{$search}%")
        ->orWhere('nombre', 'LIKE', "%{$search}%")
        ->orWhere('apellido', 'LIKE', "%{$search}%")
        ->select('id', 'nombre', 'apellido', 'email')
        ->get();

    // Retornamos array con email como id y un texto más amigable
    return response()->json(
        $alumnos->map(function ($alumno) {
            return [
                'id' => $alumno->email, 
                'text' => "{$alumno->nombre} {$alumno->apellido} - {$alumno->email}"
            ];
        })
    );

    
    }

    public function alumnosPorCarrera($id)
    {
        $alumnos = \App\Models\Usuario::where('carrera_id', $id)
                    ->select('id', 'nombre', 'apellido', 'email')
                    ->get();

        return response()->json(
            $alumnos->map(function ($alumno) {
                return [
                    'id' => $alumno->email, // el value del select será el email
                    'text' => "{$alumno->nombre} {$alumno->apellido} - {$alumno->email}"
                ];
            })
        );
    }   


    



    public function enviar(Request $request)
    {
        $data = $request->validate([
        'destinatarios' => 'nullable|array',
        'destinatarios.*' => 'email',
        'carrera_id' => 'nullable|exists:carreras,id',
        'asunto' => 'required|string|max:255',
        'mensaje' => 'required|string',
        ]);

        // Si no viene el input, inicializamos como array vacío
        $emails = $data['destinatarios'] ?? [];

        if (!empty($data['carrera_id'])) {
            $alumnosCarrera = \App\Models\Usuario::where('carrera_id', $data['carrera_id'])
                                ->pluck('email')
                                ->toArray();

            $emails = array_merge($emails, $alumnosCarrera);
        }

        // Evitamos duplicados
        $emails = array_unique($emails);

        if (empty($emails)) {
            Flasher::addError('No se encontraron destinatarios para enviar el email.', 'Error');
            return back();
        }




        foreach ($emails as $email) {
            Mail::raw($data['mensaje'], function ($message) use ($email, $data) {
                $message->to($email)
                        ->subject($data['asunto']);
            });
        }

        Flasher::addSuccess('El email se envió correctamente a los destinatarios seleccionados.', 'Éxito');
        return back();
    }


}

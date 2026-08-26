<?php

namespace App\Exports;

use App\Models\Usuario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsuariosExport implements FromCollection, WithHeadings
{
    protected $ids;

    // Recibe los IDs de los usuarios seleccionados
    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    // Devuelve la colección de datos para exportar
    public function collection()
    {
        return Usuario::whereIn('id', $this->ids)
            ->with(['carrera', 'experiencias', 'estudios', 'aptitudes', 'idiomas'])
            ->get()
            ->map(function($user){
                return [
                    'Nombre' => $user->nombre,
                    'Apellido' => $user->apellido,
                    'Email' => $user->email,
                    'Teléfono' => $user->telefono,
                    'Ciudad' => $user->ciudad_residencia,
                    'Nacionalidad' => $user->nacionalidad,
                    'Carrera' => optional($user->carrera)->carrera,
                    'Experiencia' => $user->experiencias->map(fn($e) => "$e->puesto en $e->empresa")->implode(', '),
                    'Estudios' => $user->estudios->map(fn($e) => "$e->titulo en $e->institucion")->implode(', '),
                    'Aptitudes' => $user->aptitudes->pluck('aptitud')->implode(', '),
                    'Idiomas' => $user->idiomas->map(fn($i) => "$i->idioma (Nivel: $i->nivel)")->implode(', '),
                ];
            });
    }

    // Encabezados de las columnas del Excel
    public function headings(): array
    {
        return [
            'Nombre', 'Apellido', 'Email', 'Teléfono', 'Ciudad', 'Nacionalidad', 'Carrera', 'Experiencia', 'Estudios', 'Aptitudes', 'Idiomas'
        ];
    }
}
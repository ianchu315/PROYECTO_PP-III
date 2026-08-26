<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Carbon\Carbon;

class PostulacionesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $usuarios;
    protected $oferta;

    public function __construct($usuarios, $oferta)
    {
        $this->usuarios = $usuarios;
        $this->oferta = $oferta;
    }

    public function collection()
    {
        return $this->usuarios->map(function ($user) {
            return [
                $user->nombre,
                $user->apellido,
                $user->email,
                optional($user->carrera)->descripcion,
                $user->telefono,
                $user->nacionalidad,
                $user->ciudad_residencia,
                $user->genero,
                $user->sitio_web,
                $user->fecha_nacimiento ? Carbon::parse($user->fecha_nacimiento)->format('d/m/Y') : null,

                $user->experiencias->map(fn($exp) => "{$exp->puesto} en {$exp->empresa} ({$exp->año_inicio} - " . ($exp->año_fin ?? 'Actualidad') . ")")->implode(' | '),
                $user->estudios->map(fn($est) => "{$est->titulo} en {$est->institucion} (" .
                    ($est->fecha_inicio ? $est->fecha_inicio->format('Y') : '') . ' - ' .
                    ($est->fecha_fin ? $est->fecha_fin->format('Y') : 'Actualidad') . ')')->implode(' | '),
                $user->aptitudes->pluck('aptitud')->implode(', '),
                $user->idiomas->map(fn($idioma) => $idioma->idioma . ($idioma->nivel ? " (Nivel: {$idioma->nivel})" : ''))->implode(' | '),
                $user->cvs->isNotEmpty() ? $user->cvs->pluck('nombre_archivo')->implode(' | ') : 'No adjuntó CVs',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Apellido',
            'Email',
            'Carrera',
            'Teléfono',
            'Nacionalidad',
            'Ciudad',
            'Género',
            'Sitio Web',
            'Fecha de Nacimiento',
            'Experiencia',
            'Estudios',
            'Aptitudes',
            'Idiomas',
            'CVs'
        ];
    }
}

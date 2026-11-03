<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword; // <- agregar
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait; // <- agregar
use App\Models\Calificacion;

class Usuario extends Authenticatable implements CanResetPassword
{
    use Notifiable, HasFactory, CanResetPasswordTrait; // <- agregar CanResetPasswordTrait

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'fecha_nacimiento',
        'dni',
        'genero',
        'nacionalidad',
        'ciudad_residencia',
        'pais_residencia',
        'foto_perfil',
        'descripcion',
        'sitio_web',
        'carrera_id',
        'anio_id',
        'aprobado',
        'estado',
        'rol',
        'password',
        'telefono'
    ];

    protected $casts = [
        'ultima_conexion' => 'datetime',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function carrerasAsignadas()
    {
        return $this->belongsToMany(Carrera::class, 'preceptor_carrera', 'usuario_id', 'carrera_id')
            ->withTimestamps();
    }

    public function carrerasHabilitadas()
    {
        return $this->belongsToMany(Carrera::class, 'usuario_carrera', 'usuario_id', 'carrera_id')
            ->withTimestamps();
    }

    // Registro de "profesor" en el módulo de mesas (presidente/vocal),
    // vinculado desde el panel de asignaciones para no cargar los datos
    // dos veces.
    public function profesorMesas()
    {
        return $this->hasOne(Profesor::class, 'usuario_id');
    }

    public function anio()
    {
        return $this->belongsTo(Anio::class, 'anio_id');
    }

    public function experienciasLaborales()
    {
        return $this->hasMany(ExperienciaLaboral::class, 'usuario_id');
    }

    public function aptitudes()
    {
        return $this->hasMany(Aptitud::class);
    }

    public function estudios()
    {
        return $this->hasMany(Estudio::class);
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }

    public function postulaciones()
    {
        return $this->hasMany(Postulacion::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'usuario_id');
    }

    public function getPromedioNotasAttribute()
    {
        $promedio = $this->calificaciones()
            ->whereNotNull('nota')
            ->avg('nota');

        return $promedio !== null ? round($promedio, 2) : 0.0;
    }

    public function getRegularidadAttribute()
    {
        return $this->promedio_notas >= 4 ? 'REGULAR' : 'NO REGULAR';
    }

    public function condicionEnMateria($materiaId): string
    {
    $promedio = $this->calificaciones()
        ->where('materia_id', $materiaId)
        ->where('tipo', 'cuatrimestre')
        ->whereNotNull('nota')
        ->avg('nota');

    // >= 4 en el promedio de los cuatrimestres => regular directo
    if ($promedio !== null && $promedio >= 4) {
        return 'regular';
    }

    // Si no llegó a 4, la nota extra funciona como recuperatorio:
    // si esa nota extra es >= 4, igual queda regular.
    $notaExtra = $this->calificaciones()
        ->where('materia_id', $materiaId)
        ->where('tipo', 'extra')
        ->whereNotNull('nota')
        ->value('nota');

    if ($notaExtra !== null && $notaExtra >= 4) {
        return 'regular';
    }

    return 'libre';
    }

    public function materiasInscripto()
    {
        return $this->belongsToMany(Materia::class, 'inscripcion_materia', 'usuario_id', 'materia_id')
            ->withPivot('fecha_inscripcion')
            ->withTimestamps();
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'usuario_id');
    }

    // % de asistencia del alumno. Si se pasa $materiaId, calcula solo esa
    // materia; si no, calcula sobre todas las materias con registros
    // cargados. Null cuando todavía no hay ninguna clase registrada (para
    // distinguir "sin datos" de "0% de asistencia"). Presente (2) y tardanza
    // (1) cuentan como asistidas; ausente (0) no. Una ausencia justificada
    // (ausente con motivo) no entra en el total: ni suma ni resta.
    public function porcentajeAsistencia(?int $materiaId = null): ?float
    {
        $base = fn () => $this->asistencias()
            ->where(function ($q) {
                $q->where('estado', '>', Asistencia::AUSENTE)
                  ->orWhereNull('motivo_justificacion');
            })
            ->when($materiaId !== null, fn ($q) => $q->where('materia_id', $materiaId));

        $total = $base()->count();

        if ($total === 0) {
            return null;
        }

        $presentes = $base()->where('estado', '>', Asistencia::AUSENTE)->count();

        return round(($presentes / $total) * 100, 2);
    }


    public function usuariosQueGuardaron()
    {
        return $this->belongsToMany(Usuario::class, 'ofertas_guardadas', 'oferta_id', 'usuario_id');
    }
}

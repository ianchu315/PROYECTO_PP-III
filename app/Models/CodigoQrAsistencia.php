<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

// Token de un QR de asistencia para una materia/fecha puntual. Lo genera
// el profesor desde la planilla (ver AsistenciaProfesorController) y lo
// consume el alumno al escanearlo (ver AlumnoAsistenciaController::escanear).
class CodigoQrAsistencia extends Model
{
    use HasFactory;

    protected $table = 'codigos_qr_asistencia';

    protected $fillable = [
        'materia_id',
        'fecha',
        'token',
        'tipo',
        'creado_por',
        'expira_en',
    ];

    protected $casts = [
        'fecha'     => 'date',
        'tipo'      => 'integer',
        'expira_en' => 'datetime',
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function creadoPor()
    {
        return $this->belongsTo(Usuario::class, 'creado_por');
    }

    public function getVigenteAttribute(): bool
    {
        return $this->expira_en->isFuture();
    }

    public function getEtiquetaTipoAttribute(): string
    {
        return $this->tipo === Asistencia::TARDANZA ? 'Tardanza' : 'Presente';
    }

    public static function generarToken(): string
    {
        return Str::random(40);
    }
}

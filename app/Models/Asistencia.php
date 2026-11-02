<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Registro de asistencia de un alumno a una materia en una fecha puntual.
// Lo carga el profesor a cargo de la materia: a mano desde la planilla o
// con el QR que el alumno escanea (ver AsistenciaProfesorController y
// AlumnoAsistenciaController). El preceptor solo puede consultarla.
//
// Jerarquía guardada en "estado": ausente = 0, tardanza = 1, presente = 2.
// OJO: es solo una forma compacta de guardar el dato. Lo que cuenta es el
// ÚLTIMO valor ingresado, no el mayor: si estaba presente (2) y el profesor
// lo pasa a tardanza (1), queda tardanza.
class Asistencia extends Model
{
    use HasFactory;

    public const AUSENTE  = 0;
    public const TARDANZA = 1;
    public const PRESENTE = 2;

    public const ETIQUETAS = [
        self::AUSENTE  => 'Ausente',
        self::TARDANZA => 'Tardanza',
        self::PRESENTE => 'Presente',
    ];

    protected $table = 'asistencias';

    protected $fillable = [
        'usuario_id',
        'materia_id',
        'fecha',
        'estado',
        'motivo_justificacion',
        'registrado_por',
        'codigo_qr_id',
    ];

    protected $casts = [
        'fecha'  => 'date',
        'estado' => 'integer',
    ];

    public static function valores(): array
    {
        return array_keys(self::ETIQUETAS);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    // Profesor (usuario, guard "usuarios") que cargó el registro.
    public function registradoPor()
    {
        return $this->belongsTo(Usuario::class, 'registrado_por');
    }

    public function codigoQr()
    {
        return $this->belongsTo(CodigoQrAsistencia::class, 'codigo_qr_id');
    }

    public function getEtiquetaEstadoAttribute(): string
    {
        $texto = self::ETIQUETAS[$this->estado] ?? '—';

        if ($this->estado === self::AUSENTE && $this->motivo_justificacion) {
            $texto .= ' (justificada: ' . $this->motivo_justificacion . ')';
        }

        return $texto;
    }

    // Una ausencia con motivo cargado es "justificada" y no cuenta en el %.
    public function getEsJustificadaAttribute(): bool
    {
        return $this->estado === self::AUSENTE && !empty($this->motivo_justificacion);
    }

    /**
     * Único punto de escritura: "la última carga pisa a la anterior".
     * Devuelve el registro resultante.
     */
    public static function registrar(int $usuarioId, int $materiaId, $fecha, int $estado, int $registradoPor, ?string $motivo = null, ?int $codigoQrId = null): self
    {
        return self::updateOrCreate(
            ['usuario_id' => $usuarioId, 'materia_id' => $materiaId, 'fecha' => $fecha],
            [
                'estado'               => $estado,
                'motivo_justificacion' => $estado === self::AUSENTE ? ($motivo ?: null) : null,
                'registrado_por'       => $registradoPor,
                'codigo_qr_id'         => $codigoQrId,
            ]
        );
    }
}

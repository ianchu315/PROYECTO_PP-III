<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MesaInscripcion extends Model
{
    use HasFactory;

    protected $table = 'mesa_inscripciones';

    protected $fillable = ['usuario_id', 'mesa_id', 'fecha_inscripcion', 'condicion'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }
}

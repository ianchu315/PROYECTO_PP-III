<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    use HasFactory; 
    protected $table = 'postulaciones';
    protected $fillable = [
        'usuario_id',
        'oferta_id',
        'estado_postulacion',
        'fecha_postulacion',
        'fecha_contratacion',
    ];

    public function usuario()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'usuario_id');
    }

    public function oferta()
    {
        return $this->belongsTo(\App\Models\Oferta::class, 'oferta_id');
    }

    
}


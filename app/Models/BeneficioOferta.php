<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficioOferta extends Model
{
    use HasFactory;

    protected $table = 'beneficios_ofertas';
    
    protected $fillable = [
        'oferta_id',
        'beneficio',
    ];

    public function oferta()
    {
        return $this->belongsTo(Oferta::class, 'oferta_id');
    }
}

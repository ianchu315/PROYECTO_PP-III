<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdiomasDisponibles extends Model
{
    use HasFactory;
    protected $table = 'idiomas_disponibles';
    
    protected $fillable = [
        'nombre_idioma',
        
    ];
    

    public function ofertas()
{
    return $this->belongsToMany(
        \App\Models\Oferta::class,
        'idiomas_ofertas',
        'idioma_id',
        'oferta_id'
    )->withTimestamps();
}




}

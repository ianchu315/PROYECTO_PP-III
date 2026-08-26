<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfertaGuardada extends Model
{
    public $timestamps = false;
    protected $table = 'ofertas_guardadas';

    protected $fillable = ['usuario_id', 'oferta_id', 'fecha_guardado'];

    public function oferta()
    {
        return $this->belongsTo(Oferta::class, 'oferta_id');
    }
    

}

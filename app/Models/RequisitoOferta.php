<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequisitoOferta extends Model
{
    use HasFactory;

    protected $table = 'requisitos_ofertas';

    protected $fillable = ['oferta_id', 'requisito'];

    public function oferta()
    {
        return $this->belongsTo(Oferta::class);
    }
}


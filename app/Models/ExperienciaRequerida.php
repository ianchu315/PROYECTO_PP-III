<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienciaRequerida extends Model
{
    use HasFactory;

    protected $table = 'experiencias_requeridas';

    protected $fillable = [
        'años',
        'area',
    ];
}
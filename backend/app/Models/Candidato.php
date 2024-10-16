<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    use HasFactory;
    protected $table = 'candidato';
    protected $fillable = [
        'experiencia',
        'habilidades',
        'tempo',
        'salario_min',
        'salario_max',
        'telefone',
        'id_user',
    ];
}

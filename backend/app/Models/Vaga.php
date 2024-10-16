<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    use HasFactory;

    protected $table = 'vaga';

    protected $fillable = [
        'titulo',
        'descricao',
        'habilidades',
        'experiencia',
        'requisitos',
        'localizacao',
        'data_abertura',
        'data_fechamento',
        'salario_min',
        'salario_max',
        'id_user',
        'id_tipo_contrato',
    ];

    public function tipoContrato()
    {
        return $this->belongsTo(TipoContrato::class, 'id_tipo_contrato');
    }
}

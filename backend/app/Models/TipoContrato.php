<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoContrato extends Model
{
    use HasFactory;
    protected $table = 'tipo_contrato';
    protected $fillable = ['nome'];

    public function vagas()
    {
        return $this->hasMany(Vaga::class, 'id_tipo_contrato');
    }
}

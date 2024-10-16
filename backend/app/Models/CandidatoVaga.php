<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatoVaga extends Model
{
    use HasFactory;
    
    protected $table = 'candidato_vaga';

    protected $fillable = [
        'id_candidato',
        'id_vaga',
    ];

    // Relacionamento com Candidato
    public function candidato()
    {
        return $this->belongsTo(Candidato::class, 'id_candidato');
    }

    // Relacionamento com Vaga
    public function vaga()
    {
        return $this->belongsTo(Vaga::class, 'id_vaga');
    }
}

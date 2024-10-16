<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recrutador extends Model
{
    use HasFactory;
    protected $table = 'recrutador';
    protected $fillable = [
        'telefone',
        'cargo',
        'empresa',
        'id_user',
        'autenticado',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}

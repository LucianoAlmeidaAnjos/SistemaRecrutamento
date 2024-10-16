<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidato;
use Illuminate\Support\Facades\Auth;

class CandidatoController extends Controller
{
    public function store(Request $request)
{
        $request->validate([
            'experiencia' => 'required',
            'habilidades' => 'required',
            'tempo' => 'required|integer',
            'telefone' => 'required',
        ]);

        // Criar o candidato
        Candidato::create([
            'experiencia' => $request->experiencia,
            'habilidades' => $request->habilidades,
            'tempo' => $request->tempo,
            'salario_min' => $request->salario_min,
            'salario_max' => $request->salario_max,
            'telefone' => $request->telefone,
            'id_user' => $request->id_user,
        ]);

        return response()->json(['message' => 'Perfil completado com sucesso!']);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CandidatoVaga;
use App\Models\Candidato;
use App\Models\Vaga;
use Illuminate\Support\Facades\Auth;

class CandidatoVagaController extends Controller
{
    public function inscrever(Request $request, $idVaga){
        $userId = $request->id_user;
        //$userId = auth()->id(); // Pegamos o ID do usuário autenticado
        $candidato = Candidato::where('id_user', $userId)->first(); // Encontramos o candidato baseado no id_user
        
        if (!$candidato) {
            return response()->json(['error' => 'Perfil de candidato não encontrado.'], 404);
        }

        // Verificar se o candidato já está inscrito na vaga
        $jaInscrito = CandidatoVaga::where('id_candidato', $candidato->id)
                                   ->where('id_vaga', $idVaga)
                                   ->exists();
        if ($jaInscrito) {
            return response()->json(['message' => 'Você já está inscrito nesta vaga.']);
        }

        // Criar a inscrição na vaga
        $candidatoVaga = CandidatoVaga::create([
            'id_candidato' => $candidato->id,
            'id_vaga' => $idVaga,
        ]);

        return response()->json(['message' => 'Inscrição realizada com sucesso.']);
    }

    public function verificarInscricao(Request $request, $idVaga){
        $userId = $request->id_user; // Pegamos o ID do usuário autenticado
        $candidato = Candidato::where('id_user', $userId)->first(); // Encontramos o candidato baseado no id_user

        if (!$candidato) {
            return response()->json(['error' => 'Perfil de candidato não encontrado.'], 404);
        }

        // Verificar se o candidato está inscrito na vaga
        $inscrito = CandidatoVaga::where('id_candidato', $candidato->id)
                                 ->where('id_vaga', $idVaga)
                                 ->exists();

        return response()->json(['inscrito' => $inscrito]);
    }

    public function contarCandidatos($vagaId){
        try {
            // Conta quantos registros existem na tabela candidato_vaga para a vaga específica
            $contagem = CandidatoVaga::where('id_vaga', $vagaId)->count();

            return response()->json([
                'vaga_id' => $vagaId,
                'contagem' => $contagem,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao contar candidatos',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

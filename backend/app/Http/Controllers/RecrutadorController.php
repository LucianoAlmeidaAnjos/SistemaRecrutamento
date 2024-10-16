<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recrutador;

class RecrutadorController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'telefone' => 'required|string',
            'cargo' => 'required|string',
            'empresa' => 'required|string',
            'id_user' => 'required|exists:users,id'
        ]);

        // Criar ou atualizar o perfil do recrutador
        $recrutador = Recrutador::updateOrCreate(
            ['id_user' => $request->id_user], // Condição para encontrar o recrutador
            [
                'telefone' => $request->telefone,
                'cargo' => $request->cargo,
                'empresa' => $request->empresa,
                'autenticado' => false // Definindo autenticado como false por padrão
            ]
        );

        return response()->json([
            'message' => 'Perfil do recrutador completado com sucesso.',
            'recrutador' => $recrutador
        ], 200);
    }
     // Lista todos os recrutadores
     public function index(){
        $recrutadores = Recrutador::with('user')->whereHas('user', function ($query) {
            $query->where('id', '!=', 1); // Supondo que o ID do admin é 1
        })->get();
        return response()->json($recrutadores);
     }

     public function show($id){
        $recrutador = Recrutador::with('user')->where('id_user', $id)->first();
        
        if (!$recrutador) {
            return response()->json(['message' => 'Recrutador não encontrado'], 404);
        }

        return response()->json([
            'recrutador' => $recrutador,
            'user' => $recrutador->user // Incluindo o nome e email do usuário
        ]);
    }
 
     // Atualiza um recrutador
     public function update(Request $request, $id){
         // Validação dos dados recebidos
        $request->validate([
            'autenticado' => 'required|boolean',
        ]);

        // Encontrar recrutador e atualizar
        $recrutador = Recrutador::findOrFail($id);
        $recrutador->autenticado = $request->autenticado;
        $recrutador->save();

        return response()->json(['message' => 'Recrutador atualizado com sucesso!']);
     }

     public function updateProfile(Request $request){
    $request->validate([
        'telefone' => 'required|string',
        'cargo' => 'required|string',
        'empresa' => 'required|string',
        'id_user' => 'required|exists:users,id'
    ]);

    // Atualiza o perfil do recrutador
    $recrutador = Recrutador::where('id_user', $request->id_user)->firstOrFail();
    
    $recrutador->telefone = $request->telefone;
    $recrutador->cargo = $request->cargo;
    $recrutador->empresa = $request->empresa;
    $recrutador->save();

    return response()->json([
        'message' => 'Perfil do recrutador atualizado com sucesso.',
        'recrutador' => $recrutador
    ], 200);
}
 
     // Exclui um recrutador
     public function destroy($id){
         // Encontre o recrutador pelo ID
         $recrutador = Recrutador::find($id);
         if (!$recrutador) {
             return response()->json(['message' => 'Recrutador não encontrado'], 404);
         }
 
         // Exclui o recrutador
         $recrutador->delete();
         return response()->json(null, 204);
     }
}

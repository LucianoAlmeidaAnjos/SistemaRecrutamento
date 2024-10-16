<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vaga;

class VagasController extends Controller
{
    public function cadastrar(Request $request)
    {
        // Validação dos dados recebidos
        $request->validate([
            'titulo' => 'required|string',
            'descricao' => 'required|string',
            'habilidades' => 'required|string',
            'requisitos' => 'nullable|string',
            'experiencia' => 'required|integer',
            'salario_min' => 'required|numeric',
            'salario_max' => 'nullable|numeric',
            'localizacao' => 'required|string',
            'id_tipo_contrato' => 'required|exists:tipo_contrato,id',
            'id_user' => 'required|exists:users,id',
            'data_abertura' => 'required|date',
            'data_fechamento' => 'required|date',
        ]);

        // Criação da nova vaga
        $vaga = Vaga::create([
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'habilidades' => $request->habilidades,
            'requisitos' => $request->requisitos,
            'experiencia' => $request->experiencia,
            'salario_min' => $request->salario_min,
            'salario_max' => $request->salario_max,
            'localizacao' => $request->localizacao,
            'id_user' => $request->id_user,
            'id_tipo_contrato' => $request->id_tipo_contrato,
            'data_abertura' => $request->data_abertura,
            'data_fechamento' => $request->data_fechamento,
        ]);

        return response()->json($vaga, 201);
    }

    public function listar()
    {
        // Retorna todas as vagas com as informações necessárias
        $vagas = Vaga::with('tipoContrato')->get();
        return response()->json($vagas);
    }

    public function mostrar($id)
    {
        // Retorna uma vaga específica
        $vaga = Vaga::with('tipoContrato')->find($id);
        
        if (!$vaga) {
            return response()->json(['message' => 'Vaga não encontrada'], 404);
        }
        
        return response()->json($vaga);
    }

    public function editar(Request $request, $id)
    {
        // Validação dos dados recebidos
        $request->validate([
            'titulo' => 'required|string',
            'descricao' => 'required|string',
            'habilidades' => 'required|string',
            'requisitos' => 'nullable|string',
            'experiencia' => 'required|integer',
            'salario_min' => 'required|numeric',
            'salario_max' => 'nullable|numeric',
            'localizacao' => 'required|string',
            'id_tipo_contrato' => 'required|exists:tipo_contrato,id',
        ]);

        // Busca a vaga pelo ID
        $vaga = Vaga::find($id);
        
        if (!$vaga) {
            return response()->json(['message' => 'Vaga não encontrada'], 404);
        }

        // Atualiza a vaga
        $vaga->update($request->all());

        return response()->json($vaga);
    }

    public function excluir($id)
    {
        // Busca a vaga pelo ID
        $vaga = Vaga::find($id);
        
        if (!$vaga) {
            return response()->json(['message' => 'Vaga não encontrada'], 404);
        }

        // Exclui a vaga
        $vaga->delete();

        return response()->json(['message' => 'Vaga excluída com sucesso']);
    }
}

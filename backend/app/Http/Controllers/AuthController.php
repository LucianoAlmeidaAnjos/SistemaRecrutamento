<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Candidato;
use App\Models\Recrutador;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Autenticar o usuário
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Pegar o usuário autenticado
            $user = Auth::user();

            // Verificar se é candidato ou recrutador e se já preencheu o perfil
            $perfilCompleto = false;

            if ($user->recrutador) {
                // Verifica se o recrutador tem perfil completo
                $recrutador = Recrutador::where('id_user', $user->id)->first();
                $perfilCompleto = $recrutador ? true : false;
            } else {
                // Verifica se o candidato tem perfil completo
                $candidato = Candidato::where('id_user', $user->id)->first();
                $perfilCompleto = $candidato ? true : false;
            }

            // Retornar a resposta ao front-end com o status do perfil
            return response()->json([
                'user' => $user,
                'completo' => $perfilCompleto,
            ]);
        }

        return response()->json(['error' => 'Credenciais inválidas'], 401);
    }

    // Método para criar usuários para testes
    public function register(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'recrutador' => false
        ]);

        return response()->json([
            'message' => 'Usuário registrado com sucesso',
        ], 201);
    }

    public function registerRecrutador(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'recrutador' => true
        ]);

        return response()->json([
            'message' => 'Usuário registrado com sucesso',
        ], 201);
    }
}

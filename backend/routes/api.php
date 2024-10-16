<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\RecrutadorController;
use App\Http\Controllers\VagasController;
use App\Http\Controllers\TipoContratoController;
use App\Http\Controllers\CandidatoVagaController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/registerRecrutador', [AuthController::class, 'registerRecrutador']);
Route::post('/completar-perfil', [CandidatoController::class, 'store']);
Route::post('/completar-perfil-recrutador', [RecrutadorController::class, 'store']);


Route::post('/vagas', [VagasController::class, 'cadastrar']);
Route::get('/vagas', [VagasController::class, 'listar']);
Route::get('/vagas/{id}', [VagasController::class, 'mostrar']);
Route::put('/vagas/{id}', [VagasController::class, 'editar']);
Route::delete('/vagas/{id}', [VagasController::class, 'excluir']);
Route::post('/cadastrar-vaga', [VagasController::class, 'cadastrar']);

Route::get('/tipos-contrato', [TipoContratoController::class, 'getTiposContrato']);

Route::get('/recrutadores', [RecrutadorController::class, 'index']);
Route::get('/recrutadores/{id}', [RecrutadorController::class, 'show']);
Route::put('/recrutadores/{id}', [RecrutadorController::class, 'update']);
Route::put('/alterar-perfil/{id}', [RecrutadorController::class, 'updateProfile']);
Route::delete('/recrutadores/{id}', [RecrutadorController::class, 'destroy']);

Route::post('/vaga/{vagaId}/inscricao', [CandidatoVagaController::class, 'verificarInscricao']);
Route::post('/vaga/{vagaId}/inscrever', [CandidatoVagaController::class, 'inscrever']);
Route::get('/vagas/{id}/contagem', [CandidatoVagaController::class, 'contarCandidatos']);
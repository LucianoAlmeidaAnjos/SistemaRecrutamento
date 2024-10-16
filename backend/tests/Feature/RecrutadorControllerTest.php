<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Recrutador;

class RecrutadorControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_store_creates_or_updates_recrutador()
    {
        // Cria um usuário
        $user = User::factory()->create();

        // Dados do request
        $data = [
            'telefone' => '123456789',
            'cargo' => 'Gerente de RH',
            'empresa' => 'Empresa X',
            'autenticado' => false,
            'id_user' => $user->id,
        ];

        // Faz a requisição para o método store
        $response = $this->postJson('/api/recrutadores', $data);

        // Verifica se foi criado no banco de dados
        $this->assertDatabaseHas('recrutador', [
            'telefone' => '123456789',
            'cargo' => 'Gerente de RH',
            'empresa' => 'Empresa X',
            'autenticado' => false,
            'id_user' => $user->id,
        ]);

        // Verifica o JSON de resposta
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Perfil do recrutador completado com sucesso.',
                     'recrutador' => [
                         'telefone' => '123456789',
                         'cargo' => 'Gerente de RH',
                         'empresa' => 'Empresa X',
                         'autenticado' => false,
                         'id_user' => $user->id,
                     ]
                 ]);
    }

    /** @test */
    public function test_index_lists_all_recrutadores_except_admin()
    {
        // Cria usuários e recrutadores
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Recrutador::factory()->create(['id_user' => $user1->id]);
        Recrutador::factory()->create(['id_user' => $user2->id]);

        // Faz a requisição para o método index
        $response = $this->getJson('/api/recrutadores');

        // Verifica se recrutadores foram retornados, exceto o admin
        $response->assertStatus(200)
                 ->assertJsonCount(2); // Apenas 2 recrutadores (não inclui admin)
    }

    /** @test */
    public function test_show_displays_a_recrutador()
    {
        // Cria um usuário e um recrutador
        $user = User::factory()->create();
        $recrutador = Recrutador::factory()->create(['id_user' => $user->id]);

        // Faz a requisição para o método show
        $response = $this->getJson("/api/recrutadores/{$user->id}");

        // Verifica o JSON de resposta
        $response->assertStatus(200)
                 ->assertJson([
                     'recrutador' => [
                         'id_user' => $user->id,
                         'telefone' => $recrutador->telefone,
                     ],
                     'user' => [
                         'id' => $user->id,
                         'email' => $user->email,
                     ]
                 ]);
    }

    /** @test */
    public function test_update_updates_recrutador_autenticado()
    {
        // Cria um recrutador
        $recrutador = Recrutador::factory()->create(['autenticado' => false]);

        // Dados de atualização
        $data = ['autenticado' => true];

        // Faz a requisição para o método update
        $response = $this->putJson("/api/recrutadores/{$recrutador->id}", $data);

        // Verifica se o recrutador foi atualizado no banco de dados
        $this->assertDatabaseHas('recrutador', [
            'id' => $recrutador->id,
            'autenticado' => true
        ]);

        // Verifica a resposta
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Recrutador atualizado com sucesso!']);
    }

    /** @test */
    public function test_destroy_deletes_recrutador()
    {
        // Cria um recrutador
        $recrutador = Recrutador::factory()->create();

        // Faz a requisição para o método destroy
        $response = $this->deleteJson("/api/recrutadores/{$recrutador->id}");

        // Verifica se o recrutador foi removido do banco de dados
        $this->assertDatabaseMissing('recrutadores', ['id' => $recrutador->id]);

        // Verifica o status de resposta
        $response->assertStatus(204);
    }
}

<?php

namespace Database\Factories;

use App\Models\Recrutador;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recrutador>
 */
class RecrutadorFactory extends Factory
{
    protected $model = Recrutador::class;

    public function definition()
    {
        return [
            'telefone' => $this->faker->phoneNumber,
            'cargo' => $this->faker->jobTitle,
            'empresa' => $this->faker->company,
            'id_user' => User::factory(), // Garante que um usuário seja criado
        ];
    }
}

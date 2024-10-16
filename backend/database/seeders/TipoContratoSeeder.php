<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoContrato;

class TipoContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['nome' => 'CLT'],
            ['nome' => 'PJ'],
            ['nome' => 'Estágio'],
            ['nome' => 'Temporário'],
        ];
        TipoContrato::insert($tipos);
    }
}

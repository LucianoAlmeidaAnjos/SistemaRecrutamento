<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoContrato;

class TipoContratoController extends Controller
{
    public function getTiposContrato(){
        $tipos = TipoContrato::all(); // Assumindo que a tabela é 'tipo_contrato'
        return response()->json($tipos);
    }
}

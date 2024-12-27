<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Historico;

class PlantaoUrgenciaController extends Controller
{
    public function salvarPlantaoUrgencia(Request $request)
    {
        $request->validate([
            'periodo_inicio' => 'required|date',
            'periodo_fim' => 'required|date|after_or_equal:periodo_inicio',
            'promotor_designado_id' => 'required|exists:promotores,id',
        ]);

        DB::table('plantao_atendimento')->insert([
            'periodo_inicio' => $request->input('periodo_inicio'),
            'periodo_fim' => $request->input('periodo_fim'),
            'promotor_designado_id' => $request->input('promotor_designado_id'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
    }

    public function atualizarPlantaoUrgencia(Request $request, $id)
    {
        $request->validate([
            'periodo_fim' => 'required|date|after_or_equal:periodo_inicio',
        ]);

        DB::table('plantao_atendimento')
            ->where('id', $id)
            ->update([
                'periodo_fim' => $request->input('periodo_fim'),
                'updated_at' => now(),
            ]);
    }

    public function excluirPlantaoUrgencia($id)
    {
        DB::table('plantao_atendimento')->where('id', $id)->delete();
    }

    public function listarPlantaoUrgencia()
    {
        return DB::table('plantao_atendimento as pa')
            ->join('promotores as p', 'pa.promotor_designado_id', '=', 'p.id')
            ->select('pa.id as plantao_id', 'pa.periodo_inicio', 'pa.periodo_fim', 'pa.promotor_designado_id', 'p.nome as promotor_designado')
            ->get();
    }
}
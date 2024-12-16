<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class EventoController extends Controller
{
    public function salvarEvento($data)
    {
        try {
            $validatedData = validator($data, [
                'titulo' => 'required|string',
                'tipo' => 'required|string',
                'periodo_inicio' => 'required|date',
                'periodo_fim' => 'required|date',
                'promotor_titular' => 'required',
                'promotor_designado' => 'required',
                'promotoria_id' => 'required'
            ])->validate();
            
            DB::beginTransaction();

            $evento = [
                'titulo' => $validatedData['titulo'],
                'tipo' => $validatedData['tipo'],
                'periodo_inicio' => $validatedData['periodo_inicio'],
                'periodo_fim' => $validatedData['periodo_fim'],
                'promotor_titular_id' => $validatedData['promotor_titular'],
                'promotor_designado_id' => $validatedData['promotor_designado'],
                'promotoria_id' => $validatedData['promotoria_id'],
                'is_urgente' => $data['is_urgente'] ?? false,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('eventos')->insert($evento);

            DB::commit();

            return [
                'status' => 'success',
                'message' => 'Evento salvo com sucesso'
            ];

        } catch (\Exception $e) {
            DB::rollback();
            
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
}
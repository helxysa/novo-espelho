<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PromotoriaController extends Controller
{
    public function getPromotorias()
    {
        return DB::table('grupo_promotorias AS gp')
            ->select([
                'm.nome AS municipio',
                'gp.nome AS grupo_promotoria',
                'pr.nome AS promotoria',
                'p.nome AS promotor',
                'pr.id AS promotoria_id',
                'p.id AS promotor_id'
            ])
            ->join('promotorias AS pr', 'gp.id', '=', 'pr.grupo_promotoria_id')
            ->join('promotores AS p', 'pr.promotor_id', '=', 'p.id')
            ->join('municipios AS m', 'm.id', '=', 'gp.municipios_id')
            ->get();
    }
}
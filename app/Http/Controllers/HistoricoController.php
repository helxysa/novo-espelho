<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HistoricoController extends Controller
{
    public function historico()
{
    return DB::select('
        SELECT h.users_id, u.name AS nome_usuario, h.modificado, h.detalhes AS action 
        FROM historico h
        JOIN users u ON u.id = h.users_id
    ');
}
}
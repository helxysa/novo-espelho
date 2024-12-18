<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HistoricoController extends Controller
{
    public function historico($search = null, $filter = null)
    {
        $query = "
            SELECT h.users_id, u.name AS nome_usuario, h.modificado, h.detalhes AS action 
            FROM historico h
            JOIN users u ON u.id = h.users_id
            WHERE 1=1
        ";

        if ($search) {
            $query .= " AND (h.detalhes LIKE ? OR u.name LIKE ?)";
        }

        if ($filter) {
            if ($filter === 'created') {
                $query .= " AND h.detalhes LIKE 'Criou um novo evento:%'";
            } elseif ($filter === 'deleted') {
                $query .= " AND h.detalhes LIKE 'Excluiu o evento:%'";
            }
        }

        $query .= " ORDER BY h.modificado DESC";

        return $search 
            ? DB::select($query, ["%$search%", "%$search%"])
            : DB::select($query);
    }
}
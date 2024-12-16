<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotoria extends Model
{
    use HasFactory;

    public function grupoPromotoria()
    {
        return $this->belongsTo(GrupoPromotoria::class);
    }

    public function promotorTitular()
    {
        return $this->belongsTo(Promotor::class, 'promotor_id');
    }

    public function periodos()
    {
        return $this->hasManyThrough(Periodo::class, Promotor::class, 'promotor_id', 'promotor_id');
    }

    public function promotoria()
    {
        return $this->belongsTo(Promotoria::class);
    }
}
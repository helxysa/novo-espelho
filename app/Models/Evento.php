<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 
        'tipo', 
        'periodo_inicio', 
        'periodo_fim', 
        'promotor_titular_id', 
        'promotor_designado_id',
        'is_urgente',
        'promotoria_id'
    ];

    /**
     * Relacionamento com a promotoria.
     */
    public function promotoria()
    {
        return $this->belongsTo(Promotoria::class);
    }

    /**
     * Relacionamento com o promotor titular.
     */
    public function promotorTitular()
    {
        return $this->belongsTo(Promotor::class, 'promotor_titular_id');
    }

    /**
     * Relacionamento com o promotor designado.
     */
    public function promotorDesignado()
    {
        return $this->belongsTo(Promotor::class, 'promotor_designado_id');
    }

    /**
     * Relacionamento com o período.
     */
    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }
}
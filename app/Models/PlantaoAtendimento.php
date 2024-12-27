<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantaoAtendimento extends Model
{
    use HasFactory;

    protected $table = 'plantao_atendimento';

    protected $fillable = [
        'periodo_inicio',
        'periodo_fim',
        'promotor_designado_id',
    ];

    public function promotor()
    {
        return $this->belongsTo(Promotor::class, 'promotor_designado_id');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }
}

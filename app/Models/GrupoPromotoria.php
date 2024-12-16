<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoPromotoria extends Model
{
    use HasFactory;

    public function promotorias()
    {
        return $this->hasMany(Promotoria::class);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipios_id');
    }
}

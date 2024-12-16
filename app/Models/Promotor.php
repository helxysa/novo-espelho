<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotor extends Model
{
    use HasFactory;
    protected $table = 'promotores'; 
    
    protected $fillable = ['nome', 'is_substituto'];

    public function periodos()
    {
        return $this->hasMany(Periodo::class, 'promotor_id');
    }
}
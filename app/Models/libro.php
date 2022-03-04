<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class libro extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo',
        'autor',
        'editorial',
        'descripcion',
    ];
    public function rentados()
    {
        return $this->hasMany('App\Models\Rentado', 'id_libro')->with('user');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rentado extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_usuario',
        'id_libro',
    ];
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_usuario');
    }

}

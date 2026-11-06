<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'apellido',
        'fecha nacimiento',
        'expediente',
        'imagen_url',
        'imagen_public_id',
        'module_id',
    ];
    public function module(){
        return $this->belongsTo('App\Models\Module');
    }
}

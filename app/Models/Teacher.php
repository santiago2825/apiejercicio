<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'cedula',
    ];
    public function modules(){
        return $this->belongsToMany('App\Models\Module', 'module_teachers');
    }
}

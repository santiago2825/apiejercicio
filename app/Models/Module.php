<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $fillable = [
    'codigo',
    'nombre',
    ];
    public function students(){
        return $this->hasMany('App\Models\Student');
    }
    public function teachers(){
        return $this->belongsToMany('App\Models\Teacher', 'module_teachers');
    }
}

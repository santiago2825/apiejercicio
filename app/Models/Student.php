<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Override;
use Cloudinary\Cloudinary;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'expediente',
        'imagen_url',
        'imagen_public_id',
        'module_id',
    ];
    #[Override]
    protected static function booted()
    {
        static::deleting(function (Student $student) {
            if ($student->imagen_public_id) {
                $cloudinary = new Cloudinary([
                    'cloud' => [
                        'cloud_name' => config('services.cloudinary.cloud_name'),
                        'api_key' => config('services.cloudinary.api_key'),
                        'api_secret' => config('services.cloudinary.api_secret'),
                    ],
                    'url' => ['secure' => true],
                ]);
                $cloudinary->uploadApi()->destroy($student->imagen_public_id);
            }
        });
    }
    public function module(){
        return $this->belongsTo('App\Models\Module');
    }
}

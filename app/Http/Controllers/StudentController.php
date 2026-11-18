<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(){
        $students = Student::with('module')->get();
        return response()->json($students);
    }
    public function store(Request $request){
        $request->validate([
            'nombre'=>'required|string|max:255',
            'apellido'=>'required|string|max:255',
            'fecha_nacimiento'=>'required|date',
            'expediente'=>'required|string|max:255|unique:students,expediente',
            'imagen'=>'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'module_id'=>'required|integer|exists:modules,id'
        ]);
        $file = $request->file('imagen');
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('services.cloudinary.cloud_name'),
                'api_key' => config('services.cloudinary.api_key'),
                'api_secret' => config('services.cloudinary.api_secret')
            ],
            'url' => ['secure' => true],
        ]);
        $resultado = $cloudinary->uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder'=>'students',
                'resource_type' => 'image',
            ]
        );
        $students = Student::create([
            'nombre' => $request->nombre,
            'apellido' =>$request->apellido,
            'fecha_nacimiento' =>$request->fecha_nacimiento,
            'expediente' =>$request->expediente,
            'imagen_url' =>$resultado['secure_url'],
            'imagen_public_id' =>$resultado['public_id'],
            'module_id'=>$request->module_id,
        ]);
        return response()->json($students);
    }
    public function update(Request $request, Student $students){
        $request->validate([
            'nombre'=>'required|string|max:255',
            'apellido'=>'required|string|max:255',
            'fecha_nacimiento'=>'required|date',
            'expediente'=>'required|string|max:255|unique:students,expediente,' . $students->id,
            'imagen'=>'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'module_id'=>'required|integer|exists:modules,id'
        ]);
            $students->fill($request->only([
            'nombre',
            'apellido',
            'fecha_nacimiento',
            'expediente',
            'module_id',
        ]));

    if ($request->hasFile('imagen')) {
        // Eliminar anterior si existe
        if ($students->imagen_public_id) {
            cloudinary()->destroy($students->imagen_public_id);
        }
        // Subir nueva con el helper de Laravel
        $uploaded = $request->file('imagen')->storeOnCloudinary('students');
        $students->fill([
            'imagen_url' => $uploaded->getSecureUrl(),
            'imagen_public_id' => $uploaded->getPublicId(),
        ]);
    }
    $students->save();
    return response()->json([
        'message' => 'Elemento actualizado correctamente',
        'data' => $students
    ]);
    }
    public function show($id){
        $student = Student::with('module')->find($id);
        return response()->json($student);
    }
    public function destroy(Student $student){
        $student->delete();
        return response()->json([
            'message'=>'elimado correctamente',
            'data' => $student
        ]);
    }
}

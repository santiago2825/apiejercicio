<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(){
        $teachers = Teacher::with('modules')->get();
        return response()->json($teachers);
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'cedula' => 'required|string|max:255',
            'module_id' => 'required|integer|exists:modules,id'
        ]);
        $teacher = Teacher::create($request->all());
        //sirve para llenar la tabla pivote
        $teacher->modules()->attach($request->input('module_id'));
        return response()->json($teacher);
    }
    public function show($id){
        $teacher =Teacher::with(['modules'])->find($id);
        return  response()->json($teacher);
    }
    public function update(Request $request, Teacher $teacher){
        $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'cedula' => 'required|string|max:255',
            'module_id' => 'required|integer|exists:modules,id'
        ]);
        $teacher->update($request->all());
        //sirve para llenar la tabla pivote
        $teacher->modules()->sync([$request->input('module_id')]);
        return response()->json($teacher);
    }
    public function destroy(Teacher $teacher){
        $teacher->delete();
        return response()->json($teacher);
    }

}

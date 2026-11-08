<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    //
    public function index(){
        $modules = Module::all();
        return response()->json($modules);
    }
    public function store(Request $request){
        $request->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255'
        ]);
        $module = Module::create($request->all());
        return response()->json($module);
    }
    public function update(Request $request, $id){
        $request->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255'
        ]);
        $module = Module::find($id);
        $module->update($request->all());
        return response()->json($module);
    }
    public function show($id){
        $module=Module::find($id);
        return response()->json($module);
    }
    public function destroy(Module $modulo){
        $modulo->teachers()->detach();
        $modulo->delete();
        return response()->json($modulo);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Module;
use App\Role;
use App\Permission;

class ModuleController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $modules = Module::where('id', '>', 0);
        $modules = $this->paginate($modules);
        return view('modules', ['search' => 'modules', 'modules' => $modules, ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search($search)
    {
        $modules = Module::where('name', 'LIKE', "%".$search."%")->orWhere('orden', 'LIKE', "%".$search."%");
        $modules = $this->paginate($modules);
        return view('modules', ['search' => 'modules', 'modules' => $modules, ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'orden' => 'required|string|max:255',
        ],[
            'name.required' => 'No colocaste el nombre del módulo.',
            'name.max' => 'El nombre del módulo es demasiado largo.',
            'orden.required' => 'No colocaste el orden del módulo.',
            'orden.max' => 'El orden del módulo es demasiado largo.',
        ]);
        Module::create($validatedData);
        return back()->with('success', 'Se creó correctamente el módulo '.$validatedData['name'].'.');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getone($id)
    {
        $module = Module::where('id', Crypt::decryptString($id))->first();
        unset($module->id);
        unset($module->created_at);
        unset($module->updated_at);
        return $module;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getpermissions($id)
    {
        $roles = Role::select('id', 'name')->get();
        $permisos = Permission::select('role')->where('module', Crypt::decryptString($id))->get()->pluck('role');
        foreach( $roles as $role ){
            $role->ide = Crypt::encryptString($role->id);
            $role->selected =  $permisos->contains($role->id);
            unset($role->id);
        }
        return json_encode(array('roles' => $roles));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'name' => 'required|string|max:255',
            'orden' => 'required|string|max:255',
        ],[
            'id.required' => 'No se selecciono correctamente el módulo a editar.',
            'name.required' => 'No colocaste el nombre del módulo.',
            'name.max' => 'El nombre del módulo es demasiado largo.',
            'orden.required' => 'No colocaste el orden del módulo.',
            'orden.max' => 'El orden del módulo es demasiado largo.',
        ]);
        $module = Module::where('id', Crypt::decryptString($validatedData['id']))->first();
        $module->update($validatedData);
        return back()->with('success', 'Se editó correctamente el módulo '.$validatedData['name'].'.');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit_permisionos(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'permission' => 'nullable',
        ],[
            'id.required' => 'No se selecciono correctamente el módulo a editar.',
        ]);
        $module = Module::select('name')->where('id', Crypt::decryptString($validatedData['id']))->first();
        $permisos = Permission::where('module', Crypt::decryptString($validatedData['id']))->delete();
        if(isset($validatedData['permission'])){
            foreach($validatedData['permission'] as $role){
                Permission::create([
                    'role' => Crypt::decryptString($role),
                    'module' => Crypt::decryptString($validatedData['id']),
                ]);
            }
        }
        return back()->with('success', 'Se editó correctamente los permisos del módulo '.$module->name.'.');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function delete(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
        ],[
            'id.required' => 'No se selecciono correctamente el módulo a eliminar.',
        ]);
        $module = Module::where('id', Crypt::decryptString($validatedData['id']))->first();
        $module->delete();
        return back()->with('success', 'Se eliminó correctamente el módulo '.$module->name.'.');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function paginate($model)
    {
        return $model->paginate(20);
    }
}

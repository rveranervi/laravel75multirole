<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Role;
use App\Module;
use App\Submodule;
use App\Permission;

class RoleController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $roles = Role::where('id', '>', 0);
        $roles = $this->paginate($roles);
        return view('roles', ['search' => 'roles', 'roles' => $roles, ]);
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search($search)
    {
        $roles = Role::where('name', 'LIKE', "%".$search."%");
        $roles = $this->paginate($roles);
        return view('roles', ['search' => 'roles', 'roles' => $roles, ]);
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
        ],[
            'name.required' => 'No colocaste el nombre del rol.',
            'name.max' => 'El nombre del rol es demasiado largo.',
        ]);
        Role::create($validatedData);
        return back()->with('success', 'Se creó correctamente el rol '.$validatedData['name'].'.');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getone($id)
    {
        $role = Role::where('id', Crypt::decryptString($id))->first();
        unset($role->id);
        unset($role->created_at);
        unset($role->updated_at);
        return $role;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getpermissions($id)
    {
        $modules = Module::select('id', 'name')->get();
        $permisos_mod = Permission::select('module')->where('role', Crypt::decryptString($id))->where('submodule', '0')->get()->pluck('module');
        $permisos_submod = Permission::select('submodule')->where('role', Crypt::decryptString($id))->where('module', '0')->get()->pluck('submodule');
        foreach($modules as $mod){
            $mod->ide = Crypt::encryptString($mod->id);
            $mod->selected =  $permisos_mod->contains($mod->id);
            $mod->submodules = Submodule::select('id', 'name')->where('module', $mod->id)->get();
            foreach($mod->submodules as $submod){
                $submod->ide = Crypt::encryptString($submod->id);
                $submod->selected =  $permisos_submod->contains($submod->id);
                unset($submod->id);
            }
            unset($mod->id);
        }
        return json_encode(array('modules' => $modules));
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
        ],[
            'id.required' => 'No se selecciono correctamente el rol a editar.',
            'name.required' => 'No colocaste el nombre del rol.',
            'name.max' => 'El nombre del rol es demasiado largo.',
        ]);
        $role = Role::where('id', Crypt::decryptString($validatedData['id']))->first();
        $role->update($validatedData);
        return back()->with('success', 'Se editó correctamente el rol '.$validatedData['name'].'.');
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
            'permmod' => 'nullable',
            'permsubmod' => 'nullable',
        ],[
            'id.required' => 'No se selecciono correctamente el módulo a editar.',
        ]);
        $role = Role::select('name')->where('id', Crypt::decryptString($validatedData['id']))->first();
        $permisos = Permission::where('role', Crypt::decryptString($validatedData['id']))->delete();
        if(isset($validatedData['permmod'])){
            foreach($validatedData['permmod'] as $permiso_mod){
                Permission::create([
                    'role' => Crypt::decryptString($validatedData['id']),
                    'module' => Crypt::decryptString($permiso_mod),
                ]);
            }
        }
        if(isset($validatedData['permsubmod'])){
            foreach($validatedData['permsubmod'] as $permiso_submod){
                Permission::create([
                    'role' => Crypt::decryptString($validatedData['id']),
                    'submodule' => Crypt::decryptString($permiso_submod),
                ]);
            }
        }
        return back()->with('success', 'Se editó correctamente los permisos del rol '.$role->name.'.');
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
            'id.required' => 'No se selecciono correctamente el rol a eliminar.',
        ]);
        $role = Role::where('id', Crypt::decryptString($validatedData['id']))->first();
        $role->delete();
        return back()->with('success', 'Se eliminó correctamente el rol '.$role->name.'.');
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

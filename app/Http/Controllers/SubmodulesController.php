<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Submodule;
use App\Role;
use App\Permission;

class SubmodulesController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($module)
    {
        $submodules = Submodule::where('module', Crypt::decryptString($module));
        $submodules = $this->paginate($submodules);
        return view('submodules', ['search' => 'submodules/'.$module, 'module' => $module, 'submodules' => $submodules, ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search($module, $search)
    {
        $submodules = Submodule::where('module', Crypt::decryptString($module))->where('name', 'LIKE', "%".$search."%")->orWhere('orden', 'LIKE', "%".$search."%")->orWhere('icon', 'LIKE', "%".$search."%")->orWhere('link', 'LIKE', "%".$search."%")->orWhere('titlegroup', 'LIKE', "%".$search."%");
        $submodules = $this->paginate($submodules);
        return view('submodules', ['search' => 'submodules/'.$module, 'module' => $module, 'submodules' => $submodules, ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'orden' => 'required|string|max:255',
            'module' => 'required|string',
            'icon' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'group' => 'required|string',
            'titlegroup' => 'nullable|string|max:255',
        ],[
            'orden.required' => 'No colocaste el orden del submódulo.',
            'orden.max' => 'El orden del submódulo es demasiado largo.',
            'module.required' => 'No seleccionaste el módulo del submódulo.',
            'icon.required' => 'No colocaste el icono del submódulo.',
            'icon.max' => 'El icono del submódulo es demasiado largo.',
            'name.required' => 'No colocaste el nombre del submódulo.',
            'name.max' => 'El nombre del submódulo es demasiado largo.',
            'link.required' => 'No colocaste el enlace del submódulo.',
            'link.max' => 'El enlace del submódulo es demasiado largo.',
            'group.required' => 'No indicaste si el submódulo es un grupo.',
            'titlegroup.max' => 'El orden del submódulo es demasiado largo.',
        ]);
        $validatedData['module'] = Crypt::decryptString($validatedData['module']);
        Submodule::create($validatedData);
        return back()->with('success', 'Se creó correctamente el submódulo '.$validatedData['name'].'.');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getone($id)
    {
        $submodule = Submodule::where('id', Crypt::decryptString($id))->first();
        unset($submodule->id);
        unset($submodule->module);
        unset($submodule->created_at);
        unset($submodule->updated_at);
        return $submodule;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getpermissions($id)
    {
        $roles = Role::select('id', 'name')->get();
        $permisos = Permission::select('role')->where('submodule', Crypt::decryptString($id))->get()->pluck('role');
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
            'orden' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'link' => 'required|string|max:255',
            'group' => 'required|string',
            'titlegroup' => 'nullable|string|max:255',
        ],[
            'id.required' => 'No se selecciono correctamente el submódulo a editar.',
            'orden.required' => 'No colocaste el orden del submódulo.',
            'orden.max' => 'El orden del submódulo es demasiado largo.',
            'icon.required' => 'No colocaste el icono del submódulo.',
            'icon.max' => 'El icono del submódulo es demasiado largo.',
            'name.required' => 'No colocaste el nombre del submódulo.',
            'name.max' => 'El nombre del submódulo es demasiado largo.',
            'link.required' => 'No colocaste el enlace del submódulo.',
            'link.max' => 'El enlace del submódulo es demasiado largo.',
            'group.required' => 'No indicaste si el submódulo es un grupo.',
            'titlegroup.max' => 'El orden del submódulo es demasiado largo.',
        ]);
        $submodule = Submodule::where('id', Crypt::decryptString($validatedData['id']))->first();
        $submodule->update($validatedData);
        return back()->with('success', 'Se editó correctamente el submódulo '.$validatedData['name'].'.');
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
            'id.required' => 'No se selecciono correctamente el submódulo a editar.',
        ]);
        $submodule = Submodule::select('name')->where('id', Crypt::decryptString($validatedData['id']))->first();
        $permisos = Permission::where('submodule', Crypt::decryptString($validatedData['id']))->delete();
        if(isset($validatedData['permission'])){
            foreach($validatedData['permission'] as $role){
                Permission::create([
                    'role' => Crypt::decryptString($role),
                    'submodule' => Crypt::decryptString($validatedData['id']),
                ]);
            }
        }
        return back()->with('success', 'Se editó correctamente los permisos del submódulo '.$submodule->name.'.');
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
            'id.required' => 'No se selecciono correctamente el submódulo a eliminar.',
        ]);
        $submodule = Submodule::where('id', Crypt::decryptString($validatedData['id']))->first();
        $submodule->delete();
        return back()->with('success', 'Se eliminó correctamente el submódulo '.$submodule->name.'.');
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

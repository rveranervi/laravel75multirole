<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Submoduleelement;

class SubmodulesElementsController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($submodule)
    {
        $elements = Submoduleelement::where('submodule', Crypt::decryptString($submodule));
        $elements = $this->paginate($elements);
        return view('submoduleselements', ['search' => 'submoduleelements/'.$submodule, 'submodule' => $submodule, 'elements' => $elements, ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search($submodule, $search)
    {
        $elements = Submoduleelement::where('submodule', Crypt::decryptString($submodule))->where('name', 'LIKE', "%".$search."%")->orWhere('orden', 'LIKE', "%".$search."%")->orWhere('link', 'LIKE', "%".$search."%");
        $elements = $this->paginate($elements);
        return view('submoduleselements', ['search' => 'submoduleelements/'.$submodule, 'submodule' => $submodule, 'elements' => $elements, ]);
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
            'submodule' => 'required|string',
            'name' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ],[
            'orden.required' => 'No colocaste el orden del elemento.',
            'orden.max' => 'El orden del elemento es demasiado largo.',
            'submodule.required' => 'No seleccionaste el módulo del elemento.',
            'name.required' => 'No colocaste el nombre del elemento.',
            'name.max' => 'El nombre del elemento es demasiado largo.',
            'link.required' => 'No colocaste el enlace del elemento.',
            'link.max' => 'El enlace del elemento es demasiado largo.',
        ]);
        $validatedData['submodule'] = Crypt::decryptString($validatedData['submodule']);
        Submoduleelement::create($validatedData);
        return back()->with('success', 'Se creó correctamente el elemento '.$validatedData['name'].'.');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getone($id)
    {
        $element = Submoduleelement::where('id', Crypt::decryptString($id))->first();
        unset($element->id);
        unset($element->submodule);
        unset($element->created_at);
        unset($element->updated_at);
        return $element;
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
            'name' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ],[
            'id.required' => 'No se selecciono correctamente el elemento a editar.',
            'orden.required' => 'No colocaste el orden del elemento.',
            'orden.max' => 'El orden del elemento es demasiado largo.',
            'name.required' => 'No colocaste el nombre del elemento.',
            'name.max' => 'El nombre del elemento es demasiado largo.',
            'link.required' => 'No colocaste el enlace del elemento.',
            'link.max' => 'El enlace del elemento es demasiado largo.',
        ]);
        $element = Submoduleelement::where('id', Crypt::decryptString($validatedData['id']))->first();
        $element->update($validatedData);
        return back()->with('success', 'Se editó correctamente el elemento '.$validatedData['name'].'.');
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
            'id.required' => 'No se selecciono correctamente el elemento a eliminar.',
        ]);
        $element = Submoduleelement::where('id', Crypt::decryptString($validatedData['id']))->first();
        $element->delete();
        return back()->with('success', 'Se eliminó correctamente el elemento '.$element->name.'.');
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

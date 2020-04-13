<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;

class UserController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('id', '>', 0);
        $users = $this->paginate($users);
        return view('users', ['search' => 'users', 'users' => $users, 'roles' => $this->getRoles(), ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search($search)
    {
        $users = User::where('firstname', 'LIKE', "%".$search."%")->orWhere('lastname', 'LIKE', "%".$search."%")->orWhere('email', 'LIKE', "%".$search."%");
        $users = $this->paginate($users);
        return view('users', ['search' => 'users', 'users' => $users, 'roles' => $this->getRoles(), ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        return view('profile');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update_profile(Request $request)
    {
        $id = Auth::id();
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'email' => Rule::unique('users')->ignore($id, 'id'),
            'password' => 'nullable|string|min:8|confirmed',
        ],[
            'firstname.required' => 'No colocaste el nombre del usuario.',
            'firstname.max' => 'El nombre es demasiado largo.',
            'lastname.required' => 'No colocaste el apellido del usuario.',
            'lastname.max' => 'El apellido es demasiado largo.',
            'email.required' => 'No colocaste el correo electrónico del usuario.',
            'email.email' => 'El correo electrónico es incorrecto.',
            'email.max' => 'El correo electrónico es demasiado largo.',
            'email.unique' => 'El correo electrónico ya fue registrado anteriormente.',
            'password.min' => 'La contraseña es demasiado corta. Debe tener al menos 8 carácteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);
        $user = User::where('id', $id)->first();
        if($validatedData['password']){
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        else{
            $validatedData['password'] = $user->password;
        }
        $validatedData['role'] = $user->role;
        $user->update($validatedData);
        return back()->with('success', 'Se actualizó correctamente el perfil.');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ],[
            'firstname.required' => 'No colocaste el nombre del usuario.',
            'firstname.max' => 'El nombre es demasiado largo.',
            'lastname.required' => 'No colocaste el apellido del usuario.',
            'lastname.max' => 'El apellido es demasiado largo.',
            'role.required' => 'No seleccionaste el rol del usuario.',
            'role.max' => 'El rol es demasiado largo.',
            'email.required' => 'No colocaste el correo electrónico del usuario.',
            'email.email' => 'El correo electrónico es incorrecto.',
            'email.max' => 'El correo electrónico es demasiado largo.',
            'email.unique' => 'El correo electrónico ya fue registrado anteriormente.',
            'password.required' => 'No colocaste la contraseña del usuario.',
            'password.min' => 'La contraseña es demasiado corta. Debe tener al menos 8 carácteres.',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);
        return back()->with('success', 'Se creó correctamente el usuario '.$validatedData['firstname'].' '.$validatedData['lastname'].'('.$validatedData['email'].').');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getone($id)
    {
        $user = User::where('id', Crypt::decryptString($id))->first();
        unset($user->id);
        unset($user->email_verified_at);
        unset($user->created_at);
        unset($user->updated_at);
        return $user;
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'email' => Rule::unique('users')->ignore(Crypt::decryptString($request->id), 'id'),
            'password' => 'nullable|string|min:8',
        ],[
            'id.required' => 'No se selecciono correctamente el usuario a editar.',
            'firstname.required' => 'No colocaste el nombre del usuario.',
            'firstname.max' => 'El nombre es demasiado largo.',
            'lastname.required' => 'No colocaste el apellido del usuario.',
            'lastname.max' => 'El apellido es demasiado largo.',
            'role.required' => 'No seleccionaste el rol del usuario.',
            'role.max' => 'El rol es demasiado largo.',
            'email.required' => 'No colocaste el correo electrónico del usuario.',
            'email.email' => 'El correo electrónico es incorrecto.',
            'email.max' => 'El correo electrónico es demasiado largo.',
            'email.unique' => 'El correo electrónico ya fue registrado anteriormente.',
            'password.min' => 'La contraseña es demasiado corta. Debe tener al menos 8 carácteres.',
        ]);
        $user = User::where('id', Crypt::decryptString($validatedData['id']))->first();
        if($validatedData['password']){
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        else{
            $validatedData['password'] = $user->password;
        }
        $user->update($validatedData);
        return back()->with('success', 'Se editó correctamente el usuario '.$validatedData['firstname'].' '.$validatedData['lastname'].'('.$validatedData['email'].').');
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
            'id.required' => 'No se selecciono correctamente el usuario a eliminar.',
        ]);
        $user = User::where('id', Crypt::decryptString($validatedData['id']))->first();
        $user->delete();
        return back()->with('success', 'Se eliminó correctamente el usuario '.$user->firstname.' '.$user->lastname.'('.$user->email.').');
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getRoles()
    {
        return Role::get();
    }
}

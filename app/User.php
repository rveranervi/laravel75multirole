<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'role', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function id()
    {
        return Crypt::encryptString($this->id);
    }

    public function getRole()
    {
        $role = Role::where('id', $this->role)->first();
        return $role;
    }

    public function getPermissions()
    {
        $permissions = Module::where('role', $this->role)->select('modules.id', 'modules.name')->join('permissions', 'modules.id', 'permissions.module')->orderBy('orden')->get();
        foreach($permissions as $module){
            $module->submodules = Submodule::where('submodules.module', $module->id)->where('role', $this->role)->select('submodules.id', 'submodules.module', 'submodules.icon', 'submodules.name', 'submodules.link', 'submodules.group', 'submodules.titlegroup')->join('permissions', 'submodules.id', 'permissions.submodule')->orderBy('orden')->get();
            foreach($module->submodules as $submodule){
                $submodule->elements = Submoduleelement::where('submodule', $submodule->id)->orderBy('orden')->get();
            }
        }
        return $permissions;
    }

    public function validate_access($name){
        $submodule = Submodule::where('link', '/'.$name)->first();
        if($submodule){
            if(Permission::where('submodule', $submodule->id)->where('role', $this->getRole()->id)->count()>0){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return true;
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permiso de SA en mod Sistema.
        Permission::create([
            'role' => 1,
            'module' => 1,
        ]);
        //Permiso de SA en submod Usuarios.
        Permission::create([
            'role' => 1,
            'submodule' => 1,
        ]);
        //Permiso de SA en submod Roles.
        Permission::create([
            'role' => 1,
            'submodule' => 2,
        ]);
        //Permiso de SA en submod Módulos.
        Permission::create([
            'role' => 1,
            'submodule' => 3,
        ]);
        //Permiso de SA en submod Prueba.
        Permission::create([
            'role' => 1,
            'submodule' => 4,
        ]);
    }
}

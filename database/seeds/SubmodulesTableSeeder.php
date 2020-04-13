<?php

use Illuminate\Database\Seeder;
use App\Submodule;

class SubmodulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Submodule::create([
            'id' => 1,
            'orden' => 1,
            'module' => 1,
            'icon' => 'fas fa-table',
            'name' => 'Gestión de Usuarios',
            'link' => '/users',
            'group' => 0,
        ]);
        Submodule::create([
            'id' => 2,
            'orden' => 2,
            'module' => 1,
            'icon' => 'fas fa-users',
            'name' => 'Gestión de Roles',
            'link' => '/roles',
            'group' => 0,
        ]);
        Submodule::create([
            'id' => 3,
            'orden' => 3,
            'module' => 1,
            'icon' => 'fas fa-table',
            'name' => 'Gestión de Módulos',
            'link' => '/modules',
            'group' => 0,
        ]);
        Submodule::create([
            'id' => 4,
            'orden' => 4,
            'module' => 1,
            'icon' => 'fas fa-table',
            'name' => 'Submódulos de prueba',
            'link' => '#',
            'group' => 1,
            'titlegroup' => 'Elementos de prueba:', 
        ]);
    }
}

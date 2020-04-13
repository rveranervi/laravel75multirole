<?php

use Illuminate\Database\Seeder;
use App\Submoduleelement;

class SubmoduleelementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Submoduleelement::create([
            'id' => 1,
            'orden' => 1,
            'submodule' => 4,
            'name' => 'Ejemplo de elemento 1',
            'link' => '/ejem1',
        ]);
        Submoduleelement::create([
            'id' => 2,
            'orden' => 2,
            'submodule' => 4,
            'name' => 'Ejemplo de elemento 2',
            'link' => '/ejem2',
        ]);
    }
}

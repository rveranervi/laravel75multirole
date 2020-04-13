<?php

use Illuminate\Database\Seeder;
use App\Module;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::create([
            'id' => 1,
            'orden' => 1,
            'name' => 'Sistema',
        ]);
    }
}

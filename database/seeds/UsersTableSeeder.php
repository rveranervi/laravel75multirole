<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::create([
            'id' => 1,
            'firstname' => 'Ricardo Alfonso',
            'lastname' => 'Vera Nervi',
            'email' => 'rveranervi@gmail.com',
            'password' => Hash::make('rawr2012101030'),
	        'email_verified_at' => now(),
	        'remember_token' => Str::random(10),
            'role' => 1,
        ]);
    }
}

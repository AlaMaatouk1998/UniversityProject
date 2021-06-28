<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::updateOrCreate(['email' => 'admin@admin.com'], [
            'name' => 'admin',
            'lastname' => 'admin',
            'telephone' => 123,
            'adresse_id' => 1,
            'email' => 'admin@admin.com',
            'role' => 3,
            'password' => Hash::make('password')

        ]);
    }
}

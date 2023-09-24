<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Sentro Trading',
            'email' => 'admin@sentrotrading.com',
            'password' => Hash::make('secret'),
            'birthdate' => '1991-11-30 00:00:00',
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Staff 1 - Sentro Trading',
            'birthdate' => '1991-11-30 00:00:00',
            'email' => 'staff@sentrotrading.com',
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Gusti Purwanto',
            'email' => 'gustipurwanto36@gmail.com',
            'password' => Hash::make('Gusti!@#'),
            'position' => 'Web Developer',
            'image' => 'default.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

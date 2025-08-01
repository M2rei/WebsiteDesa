<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'email' => 'pemdesngrejo@gmail.com',
            'password' => Hash::make('admindesangrejo123'), 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

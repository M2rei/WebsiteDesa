<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StrukturOrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('struktur_organisasi')->insert([
            'image' => 'image/Landing Page.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

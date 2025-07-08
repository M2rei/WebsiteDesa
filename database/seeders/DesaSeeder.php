<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('desa')->insert([
            'profile_desa' => 'Desa Ngrejo adalah salah satu desa di Kabupaten Blitar yang dikenal dengan pertanian dan kebudayaannya.',
            'sejarah' => 'Desa ini berdiri sejak zaman penjajahan Belanda dan telah berkembang pesat dalam beberapa dekade terakhir.',
            'visi' => 'Menjadi desa mandiri, maju, dan berdaya saing dengan berlandaskan nilai kearifan lokal.',
            'misi' => '1. Meningkatkan kualitas pelayanan publik\n2. Mendorong pertumbuhan ekonomi desa\n3. Mengembangkan potensi budaya dan wisata desa',
            'nomor_telepon' => '+62 123 456 789',
            'email' => 'desangrejo@gmail.com',
            'logo_url' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

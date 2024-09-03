<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomebaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::create([
            'name' => 'Universitas Merdeka Pasuruan'
        ]);

        Unit::create([
            'name' => 'Prodi Pertanian'
        ]);
        Unit::create([
            'name' => 'Prodi Hukum'
        ]);
        Unit::create([
            'name' => 'Prodi Manajemen'
        ]);

        Unit::create([
            'name' => 'Prodi Informatika'
        ]);

        Unit::create([
            'name' => 'Prodi Rekayasa Perangkat Lunak'
        ]);
    }
}

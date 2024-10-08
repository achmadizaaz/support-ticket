<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class HomebaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::create([
            'name' => 'Universitas Merdeka Pasuruan',
            'code' => 071031
        ]);
        
        Unit::create([
            'name' => 'Prodi Pertanian',
            'code' => 54211
        ]);
        Unit::create([
            'name' => 'Prodi Hukum',
            'code' => 74201
        ]);
        Unit::create([
            'name' => 'Prodi Manajemen',
            'code' => 61201
        ]);

        Unit::create([
            'name' => 'Prodi Informatika',
            'code' => 55201,
        ]);

        Unit::create([
            'name' => 'Prodi Rekayasa Perangkat Lunak',
            'code' => 58201,
        ]);
    }
}

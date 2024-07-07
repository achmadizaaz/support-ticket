<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'site-title', 'value'=> 'Laravel'],
            ['name' => 'favicon', 'value'=> NULL],
            ['name' => 'sidebar-icon', 'value'=> NULL],
            ['name' => 'sidebar-text-icon', 'value'=> 'Sidebar Menu'],
            ['name' => 'can-register', 'value' => 'yes'],
            ['name' => 'default-role', 'value'=> NULL],
            ['name' => 'can-forget-password', 'value' => 'yes'],
        ];

        Option::insert($data);
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class UserSampleExport implements  WithHeadings, WithTitle
{
    public function headings(): array
    {
        return [
            [
                'username',   'name',   'email',   'phone',  'password',   'is_active', 'homebase' , 'role_id'
            ],
            [
               'akunuser', 'Akun User', 'akunuser@exampl.ecom', '082123456789', 'sandiakun', '1 (active) / 0 (non-active)', 'check id di sheet homebase', 'check id di sheet', 
            ]
        ];
    }

        // Implementasikan metode untuk judul lembar
    public function title(): string
    {
        return 'Template User';
    }
}

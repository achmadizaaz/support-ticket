<?php

namespace App\Exports;

use App\Models\Role;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class RoleExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Role::select('id', 'name', 'is_admin')->get();
    }

    public function headings(): array
    {
        // Sesuaikan dengan nama kolom di database
        return [
            'id', 'name', 'is_admin'
        ];
    }

        // Implementasikan metode untuk judul lembar
    public function title(): string
    {
        return 'Role';
    }
}

<?php

namespace App\Exports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class UnitExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Unit::select('id', 'name')->get();
    }

    public function headings(): array
    {
        // Sesuaikan dengan nama kolom di database
        return [
            'id', 'name'
        ];
    }

        // Implementasikan metode untuk judul lembar
    public function title(): string
    {
        return 'Unit (HomeBase)';
    }
}

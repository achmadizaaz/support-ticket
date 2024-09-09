<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TemplateUserExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Template Users' => new UserSampleExport(),
            'Unit' => new UnitExport(),
            'Role' => new RoleExport(),
        ];
    }
}

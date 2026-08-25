<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PelakuOlahragaTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new PelakuOlahragaInstruksiSheet(),
            new PelakuOlahragaDataSheet(),
            new PelakuOlahragaReferensiSheet(),
        ];
    }
}

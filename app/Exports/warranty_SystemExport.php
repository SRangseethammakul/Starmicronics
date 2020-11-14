<?php

namespace App\Exports;

use App\warranty_system;
use Maatwebsite\Excel\Concerns\FromCollection;

class warranty_SystemExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return warranty_system::all();
    }
}

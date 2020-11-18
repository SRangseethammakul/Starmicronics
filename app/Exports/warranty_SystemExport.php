<?php

namespace App\Exports;

use App\warranty_system;
use Maatwebsite\Excel\Concerns\FromCollection;

class warranty_SystemExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
        ini_set('post_max_size', '256M');
        ini_set('upload_max_filesize', '256M');
        ini_set('max_execution_time', '36000');
        ini_set('memory_limit', '2048M');
    }
    public function collection()
    {
        return warranty_system::all();
    }
}

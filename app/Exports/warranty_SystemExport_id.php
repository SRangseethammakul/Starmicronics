<?php

namespace App\Exports;

use App\warranty_system;
use Maatwebsite\Excel\Concerns\FromQuery;

class warranty_SystemExport_id implements FromQuery
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($check)
    {
        ini_set('post_max_size', '256M');
        ini_set('upload_max_filesize', '256M');
        ini_set('max_execution_time', '36000');
        ini_set('memory_limit', '2048M');
        $this->check = $check;
    }
    public function query()
    {
        return warranty_system::query()->whereIn('id', $this->check);
    }
}

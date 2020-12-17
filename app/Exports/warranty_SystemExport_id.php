<?php

namespace App\Exports;

use App\warranty_system;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class warranty_SystemExport_id implements FromCollection, WithHeadings
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

    public function headings(): array
    {
        return [
            '#',
            'Serial Number',
            'Good Group',
            'Good Code',
            'Good Description',
            'Cartoon',
            'shipped_qty',
            'invoice',
            'Customer',
            'Shipped Date',
            'Location',
            'EXP Date',
            'Warranty',
        ];
    }

    public function collection()
    {
        $collection = warranty_system::query()->whereIn('id', $this->check)->get();
        $collection->map(function ($item, $key) {
            $item->serial_number = "'" . $item->serial_number;
            return $item;
        });
        return $collection;
    }
}

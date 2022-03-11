<?php

namespace App\Imports;

use App\warranty_system;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;


class new_warranty_SystemImport implements ToCollection
{
     use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            if($row[0] != null &&  $row[8] != null && is_int($row[8])){
                $new_w = new warranty_system();
                $new_w->serial_number = $row[0];
                $new_w->good_group = $row[1];
                $new_w->good_code = $row[2];
                $new_w->good_description = $row[3];
                $new_w->cartoon = $row[4];
                $new_w->shipped_qty = $row[5];
                $new_w->invoice = $row[6];
                $new_w->customer = $row[7];
                $new_w->shipped_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8])->format('Y-m-d');
                $new_w->location = $row[9];
                $new_w->expired_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10])->format('Y-m-d');
                $new_w->Warranty = $row[11];
                $new_w->save();
            }
        }
        return true;
    }
    public function rules(): array
    {
        return [
            '8' => 'required|numeric'
        ];
    }
    public function customValidationAttributes()
    {
        return [
            'required' => 'required',
            'numeric' => 'numeric'
        ];
    }
}

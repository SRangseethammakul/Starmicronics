<?php

namespace App\Imports;

use App\warranty_system;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class warranty_SystemImport implements ToModel ,WithValidation, WithBatchInserts, WithChunkReading
{
     use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try{
              return new warranty_system([
                    'serial_number'     => $row[0],
                    'good_group'    => $row[1],
                    'good_code'    => $row[2],
                    'good_description'    => $row[3],
                    'cartoon'    => $row[4],
                    'shipped_qty'    => $row[5],
                    'invoice'    => $row[6],
                    'customer'    => $row[7],
                    'shipped_date'    => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8])->format('Y-m-d'),
                    'location'    => $row[9],
                    'expired_date'    => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10])->format('Y-m-d'),
                    'Warranty'    =>  $row[11]
            ]);
        }catch (\Maatwebsite\Excel\Validators\ValidationException $failures)
        {
            return view ('file-import', compact('failures'));
        }
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
    }`
    
    public function batchSize(): int
    {
        return 10000;
    }
    
    public function chunkSize(): int
    {
        return 10000;
    }
    
}

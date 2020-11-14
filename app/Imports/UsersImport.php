<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $date = intval($row[9]);
        dd(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('d/m/Y'),$date,$row[9]);
        return new User([
            'name'     => $row[0],
            'username'    => $row[1],
            'password' => Hash::make($row[2])
        ]);
    }
}

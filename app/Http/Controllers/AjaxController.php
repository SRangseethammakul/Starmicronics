<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\warranty_system;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\warranty_SystemImport;
use App\Exports\warranty_SystemExport;
use DB;

class AjaxController extends Controller
{
    public function search(){
        $test = warranty_system::groupBy('customer')->get();
        dd($test);
    }
    public function fileImport(Request $request) 
    {
        Excel::import(new warranty_SystemImport, $request->file('file')->store('temp'));
        return redirect()->route('role.index')->with('feedback' ,'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function fileExport() 
    {
        return Excel::download(new warranty_SystemExport, 'users-collection.xlsx');
    }
}

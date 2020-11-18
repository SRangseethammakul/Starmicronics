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
use App\Exports\warranty_SystemExport_id;
use DB;

class AjaxController extends Controller
{
    public function __construct()
    {
        ini_set('post_max_size', '256M');
        ini_set('upload_max_filesize', '256M');
        ini_set('max_execution_time', '36000');
        ini_set('memory_limit', '2048M');
    }
    public function fileImport(Request $request) 
    {

        Excel::import(new warranty_SystemImport, $request->file('file')->store('temp'));
        return redirect()->route('role.index')->with('feedback' ,'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function fileExport() 
    {
        return Excel::download(new warranty_SystemExport, 'warranty_systems-'.time().'.xlsx');
    }

    public function test(Request $request){
        $check = explode(",",$request->check);
        // return (new warranty_SystemExport_id($check))->download('report.xlsx');
        return Excel::download(new warranty_SystemExport_id($check), 'warranty_systems-'.time().'.xlsx');
    }
}

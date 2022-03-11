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
use App\Imports\new_warranty_SystemImport;
use App\Exports\warranty_SystemExport;
use App\Exports\warranty_SystemExport_id;
use Carbon\Carbon;
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
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx'
        ]);
        Excel::import(new new_warranty_SystemImport, $request->file('file')->store('temp'));
        return redirect()->route('dashboard.index')->with('feedback' ,'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function fileExport() 
    {
        $current = Carbon::now()->format('Ymd');
        return Excel::download(new warranty_SystemExport, 'warranty_systems_'.$current.'.xlsx');
    }

    public function test(Request $request){
        $check = explode(",",$request->check);
        $current = Carbon::now()->format('Ymd');
        return Excel::download(new warranty_SystemExport_id($check), 'warranty_systems-id_'.$current.'.xlsx');
    }

    public function callData(Request $request){
        $datas = warranty_system::where('serial_number', 'not like', '%NO INFO%')->limit(5)->get();
        return $datas;
    }

    public function checkData(){
        $act = warranty_system::where('serial_number', '2550619051103185')->first();
        $check = $act->Warranty;
        $exp = (strcmp($check , "Out of Warranty") ? 1 : 0);
        dd($exp);
        return response()->json(['status' => 1]);
    }
}

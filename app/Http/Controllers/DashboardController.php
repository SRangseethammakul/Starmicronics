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
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $datas = warranty_system::where('serial_number', 'not like', '%NO INFO%')->groupBy('shipped_date')->get();
        $years = [];
        foreach(range(date('Y')-10, date('Y')) as $y){
            dd($y);
            $years[] = $y; 
        }
        return view('dashboard',[
            'years' => $years
        ]);
    }

    public function showData(Request $request)
    {
        $datas = warranty_system::where('serial_number', 'not like', '%NO INFO%');
        $customers = DB::select("SELECT * FROM `warranty_systems` GROUP BY customer");
        if($request->customer){
            $datas = $datas->where('customer', $request->customer);
        }else{
            $datas = $datas->where('customer', 'CLEXPERT');
        }
        if($request->warranty){
            $datas = $datas->where('Warranty', 'like', '%' . $request->warranty . '%');
        }
        if($request->start_date && $request->end_date){
            $start_date = Carbon::createFromFormat('d/m/Y', $request->start_date);
            $end_date = Carbon::createFromFormat('d/m/Y', $request->end_date);
            $datas->where('shipped_date', '>=', $start_date->format('Y-m-d'))->where('shipped_date', '<=', $end_date->addDays(1)->format('Y-m-d'));
        }
        $datas = $datas->get()->chunk(300);
        return view('showdata.index',[
            'datas' => $datas,
            'customers' => $customers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getCount(Request $request){
        $month = $request->month;
        $i_count = 0;
        $data = [];
        $clexpert_rawData = warranty_system::where('customer', 'CLEXPERT')->groupBy('good_group');
        if($month){
            $clexpert_rawData = $clexpert_rawData->whereMonth('shipped_date', '=', $month);
        }
        $clexpert_rawData = $clexpert_rawData->get();
        foreach($clexpert_rawData as $key => $item){
            $counts = warranty_system::where('good_group', $item->good_group);
            $counts = $counts->count();
            $data[] = [
                'number' => $counts,
                'name' => $item->good_group
            ];
        }
        $data_clexpert = [];
        $count_max = 0;
        $array = collect($data)->sortBy('number')->reverse()->toArray();
        foreach($array as $key => $item){
            if($key < 5){
                $data_clexpert [] = [
                    'number' => $item['number'],
                    'name' => $item['name']
                ];
            }else{
                $count_max = $count_max + $item['number'];
            }
        }
        $data_clexpert[] = [
            'number' => $count_max,
            'name' => 'other'
        ];

        $Clex_rawData = warranty_system::where('customer', 'CLEXPERT')->groupBy('good_group')->get();
        $data = array();
        foreach($Clex_rawData as $key => $item){
            $counts = warranty_system::whereMonth(
                'shipped_date', '=', Carbon::now()->subMonth()->month
            )->where('good_group', $item->good_group)->count();
            $data[] = [
                'number' => $counts,
                'name' => $item->good_group
            ];
        }
        $data_Clex = [];
        $count_max = 0;
        $array = collect($data)->sortBy('number')->reverse()->toArray();
        foreach($array as $key => $item){
            if($key < 5){
                $data_Clex [] = [
                    'number' => $item['number'],
                    'name' => $item['name']
                ];
            }else{
                $count_max = $count_max + $item['number'];
            }
        }
        $data_Clex[] = [
            'number' => $count_max,
            'name' => 'other'
        ];


        $Clexpert_Year_rawData = warranty_system::where('customer', 'CLEXPERT')->groupBy('good_group')->get();
        $data = array();
        foreach($Clexpert_Year_rawData as $key => $item){
            $counts = warranty_system::whereYear(
                'shipped_date', '=', Carbon::now()->year
            )->where('good_group', $item->good_group)->count();
            $data[] = [
                'number' => $counts,
                'name' => $item->good_group
            ];
        }
        $data_clexpert_year = [];
        $count_max = 0;
        $array = collect($data)->sortBy('number')->reverse()->toArray();
        foreach($array as $key => $item){
            if($key < 4){
                $data_clexpert_year [] = [
                    'number' => $item['number'],
                    'name' => $item['name']
                ];
            }else{
                $count_max = $count_max + $item['number'];
            }
        }
        $data_clexpert_year[] = [
            'number' => $count_max,
            'name' => 'other'
        ];
        return response()->json(['status' => 1, 'CLEXPERT' => $data_clexpert, 'Clex' => $data_Clex, 'ClexpertYear' => $data_clexpert_year]);
        
    }
}

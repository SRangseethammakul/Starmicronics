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
        $year = $request->year;
        $i_count = 0;
        $data = [];
        $clexpert_rawData = warranty_system::where('customer', 'CLEXPERT')->groupBy('good_group');
        if($month){
            $clexpert_rawData = $clexpert_rawData->whereMonth('shipped_date', '=', $month);
        }
        if($year){
            $clexpert_rawData = $clexpert_rawData->whereYear('shipped_date', '=', $year);
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


        $Clexpert_Year_rawData = warranty_system::where('customer', 'CLEXPERT')->groupBy('good_group');
        if($request->clexprtYear){
            $Clexpert_Year_rawData = $Clexpert_Year_rawData->whereYear('shipped_date', '=', (int)$request->clexprtYear);
        }
        $Clexpert_Year_rawData = $Clexpert_Year_rawData->get(); 
        $data = array();
        foreach($Clexpert_Year_rawData as $key => $item){
            $counts = warranty_system::where('good_group', $item->good_group)->count();
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

        // ----
        $total_rawData_CLEXPERT = warranty_system::where('serial_number', 'not like', '%NO INFO%')->where('customer', 'like', '%CLEXPERT%');
        $total_rawData_NEC = warranty_system::where('serial_number', 'not like', '%NO INFO%')->where('customer', 'like', '%NEC%');
        $total_rawData_RADIANT = warranty_system::where('serial_number', 'not like', '%NO INFO%')->where('customer', 'like', '%RADIANT%');
        if($request->total_month){
            $total_rawData_CLEXPERT = $total_rawData_CLEXPERT->whereMonth('shipped_date', '=', $request->total_monthM);
            $total_rawData_NEC = $total_rawData_NEC->whereMonth('shipped_date', '=', $request->total_monthM);
            $total_rawData_RADIANT = $total_rawData_RADIANT->whereMonth('shipped_date', '=', $request->total_monthM);
        }
        if($request->total_year){
            $total_rawData_CLEXPERT = $total_rawData_CLEXPERT->whereYear('shipped_date', '=', $request->total_Year);
            $total_rawData_NEC = $total_rawData_NEC->whereYear('shipped_date', '=', $request->total_Year);
            $total_rawData_RADIANT = $total_rawData_RADIANT->whereYear('shipped_date', '=', $request->total_Year);
        }
        $data_total = [
            'CLEXPERT' => $total_rawData_CLEXPERT->count(),
            'NEC' => $total_rawData_NEC->count(),           
            'RADIANT' => $total_rawData_RADIANT->count()
        ];
        // ----

        // sP4
        $dataAll = [];
        $clexpert_rawDataAll = warranty_system::groupBy('good_group');
        if($request->all_year){
            $clexpert_rawDataAll = $clexpert_rawDataAll->whereYear('shipped_date', '=', (int)$year);
        }
        $clexpert_rawDataAll = $clexpert_rawDataAll->get();
        foreach($clexpert_rawDataAll as $key => $item){
            $counts = warranty_system::where('good_group', $item->good_group);
            $counts = $counts->count();
            $dataAll[] = [
                'number' => $counts,
                'name' => $item->good_group
            ];
        }
        $data_all = [];
        $count_max = 0;
        $array = collect($dataAll)->sortBy('number')->reverse()->toArray();
        foreach($array as $key => $item){
            if($key < 5){
                $data_all [] = [
                    'number' => $item['number'],
                    'name' => $item['name']
                ];
            }else{
                $count_max = $count_max + $item['number'];
            }
        }
        $data_all[] = [
            'number' => $count_max,
            'name' => 'other'
        ];
        return response()->json(['status' => 1, 
            'CLEXPERT' => $data_clexpert, 
            'Clex' => $data_Clex, 
            'ClexpertYear' => $data_clexpert_year, 
            'dataTotal' => $data_total,
            'dataAll' => $data_all
        ]);
    }

    public function dataAll(Request $request){
        $dataAll = [];
        $clexpert_rawDataAll = warranty_system::groupBy('good_group');
        if($request->all_year){
            $clexpert_rawDataAll = $clexpert_rawDataAll->whereYear('shipped_date', '=', (int)$request->all_year);
        }
        $clexpert_rawDataAll = $clexpert_rawDataAll->get();
        foreach($clexpert_rawDataAll as $key => $item){
            $counts = warranty_system::where('good_group', $item->good_group);
            $counts = $counts->count();
            $dataAll[] = [
                'number' => $counts,
                'name' => $item->good_group
            ];
        }
        $data_all = [];
        $count_max = 0;
        $array = collect($dataAll)->sortBy('number')->reverse()->toArray();
        foreach($array as $key => $item){
            if($key < 5){
                $data_all [] = [
                    'number' => $item['number'],
                    'name' => $item['name']
                ];
            }else{
                $count_max = $count_max + $item['number'];
            }
        }
        $data_all[] = [
            'number' => $count_max,
            'name' => 'other'
        ];
        return response()->json(['status' => 1, 
            'dataAll' => $data_all
        ]);
    }

    public function dataTotal(Request $request){
        $total_rawData_CLEXPERT = warranty_system::where('serial_number', 'not like', '%NO INFO%')->where('customer', 'like', '%CLEXPERT%');
        $total_rawData_NEC = warranty_system::where('serial_number', 'not like', '%NO INFO%')->where('customer', 'like', '%NEC%');
        $total_rawData_RADIANT = warranty_system::where('serial_number', 'not like', '%NO INFO%')->where('customer', 'like', '%RADIANT%');
        if($request->total_month){
            $total_rawData_CLEXPERT = $total_rawData_CLEXPERT->whereMonth('shipped_date', '=', (int)$request->total_month);
            $total_rawData_NEC = $total_rawData_NEC->whereMonth('shipped_date', '=', (int)$request->total_month);
            $total_rawData_RADIANT = $total_rawData_RADIANT->whereMonth('shipped_date', '=', (int)$request->total_month);
        }
        if($request->total_year){
            $total_rawData_CLEXPERT = $total_rawData_CLEXPERT->whereYear('shipped_date', '=', (int)$request->total_year);
            $total_rawData_NEC = $total_rawData_NEC->whereYear('shipped_date', '=', (int)$request->total_year);
            $total_rawData_RADIANT = $total_rawData_RADIANT->whereYear('shipped_date', '=', (int)$request->total_year);
        }
        $data_total = [
            'CLEXPERT' => $total_rawData_CLEXPERT->count(),
            'NEC' => $total_rawData_NEC->count(),           
            'RADIANT' => $total_rawData_RADIANT->count()
        ];
        return response()->json(['status' => 1, 
            'dataTotal' => $data_total
        ]);
    }

    public function dataClexpert(Request $request){
        $month = $request->month;
        $year = $request->year;
        $i_count = 0;
        $data = [];
        $clexpert_rawData = warranty_system::where('customer', 'CLEXPERT');
        if($month){
            $clexpert_rawData = $clexpert_rawData->whereMonth('shipped_date', '=', (int)$month);
        }
        if($year){
            $clexpert_rawData = $clexpert_rawData->whereYear('shipped_date', '=', (int)$year);
        }
        $clexpert_rawData = $clexpert_rawData->groupBy('good_group')->get();
        foreach($clexpert_rawData as $key => $item){
            $meta_data = warranty_system::where('customer', 'CLEXPERT');
            if($month){
                $meta_data = $meta_data->whereMonth('shipped_date', '=', (int)$month);
            }
            if($year){
                $meta_data = $meta_data->whereYear('shipped_date', '=', (int)$year);
            }
            $counts = $meta_data->where('good_group', $item->good_group)->count();
            $i_count++;
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
        return response()->json(['status' => 1, 
            'CLEXPERT' => $data_clexpert
        ]);
    }

    public function dataClexpertYear(Request $request){
        $Clexpert_Year_rawData = warranty_system::where('customer', 'CLEXPERT')->groupBy('good_group');
        if($request->clexprtYear){
            $Clexpert_Year_rawData = $Clexpert_Year_rawData->whereYear('shipped_date', '=', (int)$request->clexprtYear);
        }
        $Clexpert_Year_rawData = $Clexpert_Year_rawData->get(); 
        $data = array();
        foreach($Clexpert_Year_rawData as $key => $item){
            $counts = warranty_system::where('good_group', $item->good_group)->count();
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
        return response()->json(['status' => 1, 
            'ClexpertYear' => $data_clexpert_year, 
        ]);
    }
}

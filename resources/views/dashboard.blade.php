@extends('layouts.backend')
@section('contentcss')
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
<h1 class="m-0 text-dark">Dashboard</h1>
</div>
<section class="content" id="app">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!-- DONUT CHART -->
                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">CLEXPERT</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="order_delivery">Month</label>
                                    <select class="form-control part1" id="warranty_month" name="warranty_month">
                                        <option value="">Select Month</option>
                                        <option value=1>January</option>
                                        <option value=2>February</option>
                                        <option value=3>March</option>
                                        <option value=4>April</option>
                                        <option value=5>May</option>
                                        <option value=6>June</option>
                                        <option value=7>July</option>
                                        <option value=8>August</option>
                                        <option value=9>September</option>
                                        <option value=10>October</option>
                                        <option value=11>November</option>
                                        <option value=12>December</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="order_delivery">Year</label>
                                    <select class="form-control part1" id="warranty_year" name="warranty_year">
                                        <option value="">Select Year</option>
                                        @foreach ($years as $year)
                                            <option value="{{$year}}">{{$year}}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <canvas id="donutChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- DONUT CHART -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">CLEXPERT By Year</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool txt-white" data-card-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool txt-white" data-card-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="clexprtYear">Year</label>
                                    <select class="form-control" id="clexprtYear" name="clexprtYear">
                                        <option value="">Select Year</option>
                                        @foreach ($years as $year)
                                            <option value="{{$year}}">{{$year}}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <canvas id="donutChartClex"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <!-- DONUT CHART -->
                <div class="card card-dark">
                    <div class="card-header">
                        <h3 class="card-title">Clexpert, NEC, RADIANT M </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="order_delivery">Month</label>
                                    <select class="form-control part3" id="total_month" name="total_month">
                                        <option value="">Select Month</option>
                                        <option value=1>January</option>
                                        <option value=2>February</option>
                                        <option value=3>March</option>
                                        <option value=4>April</option>
                                        <option value=5>May</option>
                                        <option value=6>June</option>
                                        <option value=7>July</option>
                                        <option value=8>August</option>
                                        <option value=9>September</option>
                                        <option value=10>October</option>
                                        <option value=11>November</option>
                                        <option value=12>December</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="order_delivery">Year</label>
                                    <select class="form-control part3" id="total_year" name="tottal_year">
                                        <option value="">Select Year</option>
                                        @foreach ($years as $year)
                                            <option value="{{$year}}">{{$year}}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <canvas id="donutChartTotal"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <!-- DONUT CHART -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Clexpert, NEC, RADIANT M </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="order_delivery">Year</label>
                                    <select class="form-control" id="all_year" name="all_year">
                                        <option value="">Select Year</option>
                                        @foreach ($years as $year)
                                            <option value="{{$year}}">{{$year}}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <canvas id="donutChartAll"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
</section>
@endsection
@section('footerscript')
<script>
    $(document).ready(function () {
        getAPI();
    });
    function getAPI(){
        let month_val = $('#warranty_month').val(); //p1
        let year_val = $('#warranty_year').val(); //p1
        let clexprtYear = $('#clexprtYear').val(); //p2
        let total_month = $('#total_month').val(); //p3
        let total_year = $('#total_year').val(); //p3
        let all_year = $('#all_year').val();
        var dataPoints = [];
        var dataNames = [];
        var dataPointsYear = [];
        var dataNamesYear = [];
        var dataPointsTotal = [];
        var dataNamesTotal = [];
        var dataPointsAll = [];
        var dataNamesAll = [];
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
        var donutChartClexCanvas = $('#donutChartClex').get(0).getContext('2d');
        var donutChartTotalCanvas = $('#donutChartTotal').get(0).getContext('2d');
        var donutChartAllCanvas = $('#donutChartAll').get(0).getContext('2d');
        var donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        var donutData = {
            labels: dataNames,
            datasets: [{
                data: dataPoints,
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#A9F2E5'],
            }]
        }
        var donutDataYear = {
            labels: dataNamesYear,
            datasets: [{
                data: dataPointsYear,
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#A9F2E5'],
            }]
        }
        var donutDataTotal = {
            labels: dataNamesTotal,
            datasets: [{
                data: dataPointsTotal,
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#A9F2E5'],
            }]
        }
        var donutDataAll = {
            labels: dataNamesAll,
            datasets: [{
                data: dataPointsAll,
                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#A9F2E5'],
            }]
        }
        var donutChart = new Chart(donutChartCanvas, {
            type: 'pie',
            data: donutData,
            options: donutOptions
        });
        var donutChartClex = new Chart(donutChartClexCanvas, {
            type: 'pie',
            data: donutDataYear,
            options: donutOptions
        });
        var donutChartTotal = new Chart(donutChartTotalCanvas, {
            type: 'pie',
            data: donutDataTotal,
            options: donutOptions
        });
        var donutChartAll = new Chart(donutChartAllCanvas, {
            type: 'pie',
            data: donutDataAll,
            options: donutOptions
        });
        
        $.ajax({
            url: '{{ route('dashboard.getCount') }}',
            method: 'GET',
            data: {
                month : month_val,
                year : year_val,
                clexprtYear : clexprtYear,
                total_month : total_month,
                total_year : total_year,
                all_year : all_year
            },
            success: function (response) {
                if (response.status) {
                    if(response.CLEXPERT){
                        $.each(response.CLEXPERT, function (index, item) {
                            dataPoints.push(item.number);
                            dataNames.push(item.name);
                        });
                        var donutData = {
                            labels: dataNames,
                            datasets: [{
                                data: dataPoints
                            }]
                        }
                        donutChart.update();
                    }
                    if(response.ClexpertYear){
                        $.each(response.ClexpertYear, function (index, item) {
                            dataPointsYear.push(item.number);
                            dataNamesYear.push(item.name);
                        });
                        var donutDataYear = {
                            labels: dataNamesYear,
                            datasets: [{
                                data: dataPointsYear
                            }]
                        }
                        donutChartClex.update();
                    }
                    if(response.dataTotal){
                        $.each(response.dataTotal, function (index, item) {
                            dataPointsTotal.push(item);
                            dataNamesTotal.push(index);
                        });
                        var donutDataTotal = {
                            labels: dataNamesTotal,
                            datasets: [{
                                data: dataPointsTotal
                            }]
                        }
                        donutChartTotal.update();
                    }
                    if(response.dataAll){
                        $.each(response.dataAll, function (index, item) {
                            dataPointsAll.push(item.number);
                            dataNamesAll.push(item.name);
                        });
                        var donutDataAll = {
                            labels: dataNamesAll,
                            datasets: [{
                                data: dataPointsAll
                            }]
                        }
                        donutChartAll.update();
                    }

                } else {
                    Swal.fire({
                        title: 'ไม่สำเร็จ กรุณาลองอีกครั้ง',
                        icon: 'error',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            }
        });
    }

    $(".part1").on('change', function(){
        getAPI();
    });
    $(".part3").on('change', function(){
        getAPI();
    });
    $("#clexprtYear").on('change', function(){
        getAPI();
    });
    $("#all_year").on('change', function(){
        getAPI();
    });

</script>
@if(session('feedback'))
<script>
    Swal.fire(
        '{{ session('feedback')}}', //
        'You clicked the button!',
        'success'
    )
</script>
@endif
@endsection

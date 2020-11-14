@extends('layouts.backend')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
        </div>
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
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                    class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="donutChartClex"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<br>
<section class="content" id="app">
    <div class="container mt-5">
    </div>
</section>
@endsection
@section('footerscript')
<script>
    $(document).ready(function () {
        var dataPoints = [];
        var dataNames = [];
        var dataPointsYear = [];
        var dataNamesYear = [];
        var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
        var donutChartClexCanvas = $('#donutChartClex').get(0).getContext('2d');
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
            labels: dataNames,
            datasets: [{
                data: dataPointsYear,
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
        $.ajax({
            url: '{{ route('dashboard.getCount') }}',
            method: 'GET',
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

                } else {
                    Swal.fire({
                        title: 'ไม่สำเร็จ กรุณาลองอีกครั้ง',
                        type: 'error',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            }
        });
    });

</script>
@endsection

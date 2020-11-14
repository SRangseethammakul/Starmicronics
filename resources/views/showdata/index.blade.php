@extends('layouts.backend')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Data</h1>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <br>
    <section class="content" id="app">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-auto mr-auto"><h3>Data</h3></div>
                    {{-- <div class="col-auto"><a href="{{ route('dashboard.index')}}"> <button type="button" class="btn btn-dark">เพิ่มประเภทร้านค้า</button> </a></div> --}}
                </div>
            </div>
            <div class="row">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col"></th>
                            <th scope="col">Serial Number</th>
                            <th scope="col">Good Group</th>
                            <th scope="col">Good Code</th>
                            <th scope="col">Good Description</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Shipped Date</th>
                            <th scope="col">EXP Date</th>
                            <th scope="col">Warranty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $key => $item)
                                <tr>
                                    <th scope="row">{{ ++$key }}</th>
                                    <td>{{ $item->serial_number }}</td>
                                    <td>{{ $item->good_group }}</td>
                                    <td>{{ $item->good_code }}</td>
                                    <td>{{ $item->good_description }}</td>
                                    <td>{{ $item->customer }}</td>
                                    <td>{{ $item->shipped_date }}</td>
                                    <td>{{ $item->expired_date }}</td>
                                    <td>{{ $item->Warranty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- end row --}}
        </div>
    </section>
@endsection
@section('footerscript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('table').DataTable();
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
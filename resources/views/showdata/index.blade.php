@extends('layouts.backend')
@section('content')
<div class="content-header">
<h1 class="m-0 text-dark">Data Table</h1>
</div>
<!-- /.content-header -->

<section class="content" id="app">
    <div class="container-fluid">
        <div class="m-b-15">
            <div class="row">
                @role('Admin|Staff')
                <div class="col-auto mr-auto">
                    <button type="button" id="btn-export-xlsx" class="btn btn-dark">Excel with checkbox</button>
                    <a href="{{ route('export.excel')}}">
                        <button type="button" id="btn-export-xlsx" class="btn btn-dark">Import Excel</button>
                    </a>
                    <a href="{{ route('file-export')}}">
                        <button type="button" id="btn-export-xlsx" class="btn btn-dark">Export Excel</button>
                    </a>
                </div>
                @endrole
                <div class="col-auto ml-auto">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> <i
                            class="fas fa-filter"></i> Filter</button>
                </div>
            </div>
        </div>

        <div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover dataTable dtr-inline">
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
                        @foreach ($item as $m)
                        <tr>
                            <td><input type="checkbox" class="check-boxes" name="input[]" data-id="{{ $m->id }}">
                            </td>
                            <td>{{ $m->serial_number }}</td>
                            <td>{{ $m->good_group }}</td>
                            <td>{{ $m->good_code }}</td>
                            <td>{{ $m->good_description }}</td>
                            <td>{{ $m->customer }}</td>
                            <td>{{ $m->shipped_date }}</td>
                            <td>{{ $m->Warranty == 'Under Warranty' ? $m->expired_date : "No Date" }}</td>
                            <td>{{ $m->Warranty }}</td>
                        </tr>    
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- end row --}}
    </div>
</section>

{{-- modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="searchForm" enctype="application/x-www-form-urlencoded"
                    action="{{ route('dashboard.showData') }}" method="GET">
                    <div class="setings-item">
                        <div class="form-group">
                            <label for="customer">Select Customer</label>
                            <select class="form-control" id="customer" name="customer">
                                @foreach ($customers as $customer)
                                    <option value="{{$customer->customer}}">{{$customer->customer}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="warranty">Select Warranty</label>
                            <select class="form-control" id="warranty" name="warranty">
                                <option value="">Select Warranty</option>
                                <option value="Under Warranty">Under Warranty</option>
                                <option value="No Warranty">No Warranty</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="order_delivery">StartDate</label>
                            <input type="text" class="form-control datepicker" id="datepicker1" autocomplete="off"
                                name="start_date">
                        </div>
                        <div class="form-group">
                            <label for="order_delivery">EndDate</label>
                            <input type="text" class="form-control datepicker" id="datepicker2" autocomplete="off"
                                name="end_date">
                        </div>
                    </div>
                    <div class="setings-item">
                        <button id="btn_filter" type="submit" class="btn btn-primary">View</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footerscript')
<script type="text/javascript">
    $(document).ready(function() {
        $('table').DataTable({
            "aLengthMenu": [[20, 50, 100], [20, 50, 100]],
            "iDisplayLength": 20,
            "language": {
                "info": "Showing _START_ to _END_ total _TOTAL_",
            }
        });
    });
    $(".datepicker").datepicker({
        dateFormat: 'dd/mm/yy',
        buttonImageOnly: true,
        buttonText: "Select date"
    });
    $('#btn-export-xlsx').on('click', function() {
        var checkarr = '';
        var countar = 0;
        $('.check-boxes').each(function() {
            var $this = $(this),
                id = $this.data('id')
            if ($(this).prop('checked')) {
                if (countar == 0) {
                    checkarr = checkarr + 'check=' + id;
                }
                checkarr = checkarr + ',' + id;
                countar++;
            }

        });

        window.location.href = "{{ route('test')}}" + "?" + checkarr;
    });
</script>
@if(session('feedback'))
<script>
Swal.fire(
    '{{ session('
    feedback ')}}', //
    'You clicked the button!',
    'success'
);
</script>
@endif
@endsection

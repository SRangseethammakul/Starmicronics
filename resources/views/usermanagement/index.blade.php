@extends('layouts.backend')
@section('content')
<div class="content-header">
<h1 class="m-0 text-dark">User Management</h1>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content" id="app">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-2 col-md-3 col-12 m-b-15"><a href="{{ route('usermanagement.create')}}"> <button type="button"
                        class="btn btn-dark btn-full-w">เพิ่ม User</button> </a></div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table table-bordered table-hover dataTable dtr-inline">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Name</th>
                        <th scope="col">UserName</th>
                        <th scope="col">วันที่เพิ่ม</th>
                        <th scope="col">Tools</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $item)
                    <tr>
                        <th scope="row">{{ ++$key }}</th>
                        <td>{{$item->name}}</a></td>
                        <td>{{ $item->username }}</td>
                        <td>{{ Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('usermanagement.edit',['id'=>$item->id])}}" class="btn btn-info mr-2">
                                <li class="fas fa-pencil-ruler text-white"></li>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- end row --}}
    </div>
</section>
@endsection
@section('footerscript')
<script type="text/javascript">
$(document).ready(function() {
    $('table').DataTable();
});
$('.chk1').on('change', function() {
    var dataId = $(this).attr("data-id");
    $.ajax({
        url: '/user/ajax/updatePublish',
        method: 'GET',
        data: {
            id: dataId,
            verify: ($(this).prop('checked') ? 1 : 0)
        },
        success: function(response) {
            if (response.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    timer: 1000,
                    showConfirmButton: false
                });
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
@if(session('feedback'))

<script>
Swal.fire(
    '{{ session('
    feedback ')}}', //
    'You clicked the button!',
    'success'
)
</script>
@endif
@endsection

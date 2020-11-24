@extends('layouts.backend')
@section('content')
    <div class="content-header">
    <h1 class="m-0 text-dark">Role</h1>
    </div>
    <!-- /.content-header -->
    <section class="content" id="app">
        <div class="container-fluid">
        <div class="row">
                    <div class="col-xl-2 col-md-3 col-12 m-b-15"><a href="{{ route('role.create')}}"> <button type="button" class="btn btn-dark btn-full-w">Role</button> </a></div>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover dataTable dtr-inline">
                        <thead>
                            <tr>
                            <th scope="col">Id</th>
                            <th scope="col">ชื่อ</th>
                            <th scope="col">วันที่เพิ่ม</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $item)
                                <tr>
                                    <th scope="row">{{ ++$key }}</th>
                                    <td>{{$item->name}}</a></td>
                                    <td>{{ Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
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
        $(document).ready(function () {
            $('table').DataTable();
        });
        $('.btn-delete').on('click', function() {
            var id = $(this).data('rowid');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'api/storetype/destroy',
                        method: 'GET',
                        data: {
                            id: id
                        },
                        success: function (response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ลบข้อมูลสำเร็จ'
                                }).then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'ลบข้อมูลไม่สำเร็จ!',
                                    footer: '<a href>Why do I have this issue?</a>'
                                });
                            }
                            
                        }
                    });
                }
            });
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
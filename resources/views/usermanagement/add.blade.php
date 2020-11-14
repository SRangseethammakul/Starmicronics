@extends('layouts.backend')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">New User</h1>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <br>
    <section class="content" id="app">
        <div class="container">
            <form method="post" id="userform"  enctype="multipart/form-data">
            @csrf
                <div class="form-group mt-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group mt-2">
                    <label for="new_user_name">Username<div id="checkNameResult"></div></label>
                    <input type="text" class="form-control" id="new_user_name"  name="new_user_name" autocomplete="off" required>
                </div>

                <label for="pass">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                
                <label for="exampleFormControlSelect1" class="mt-3">Role</label>
                <select class="form-control" id="exampleFormControlSelect1" name="user_role">
                    @foreach ($roles as $item)
                        <option value="{{$item->name}}">{{$item->name}}</option>
                    @endforeach
                </select>
                <button type="submit" id="saveBtn" class="btn btn-primary mt-3">New User</button>
            </form>
        </div>
    </section>
@endsection
@section('footerscript')
<script type="text/javascript">
    var _xhr;
    var _check = 0;
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function startSearch(){
        var search = $('#new_user_name').val();
        _xhr = $.ajax({
            url: '{{ route('usermanagement.checkUser') }}',
            method: 'GET',
            data: {
                user : search
            },
            success: function (response) {
                if (response.status == 1) {
                    _check = 1;
                    var html_q =
                    `
                        <span class="badge badge-success">สามารถใช้ได้</span>
                    `
                    $("#checkNameResult").append(html_q);
                }else{
                    _check = 0;
                    var html_q =
                    `
                        <span class="badge badge-danger">ไม่สามารถใช้ได้</span>
                    `
                    $("#checkNameResult").append(html_q);
                } 
            }
        });
    }
    $('#new_user_name').on('keyup', function() {
        _xhr && _xhr.abort();
        $('#result').html('');
        $('#checkNameResult').html('');
        var num = $('#new_user_name').val();
        if(num.length > 0){
            startSearch();
        }
    });

    $('#saveBtn').on('click', function (e) {
        event.preventDefault();
        if(_check == 0){
            Swal.fire(
                'โปรดตรวจสอบชื่อ User',
                'โปรดลองอีกครั้ง',
                'question'
            );
        }
        if(_check == 1){
            Swal.fire({
            title: 'คุณต้องการเพิ่ม User ใช่ไหม',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6ec2b1',
            cancelButtonColor: '#ff7b7b',
            confirmButtonText: 'เพิ่ม',
            cancelButtonText: 'ยกเลิก',
            focusCancel: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        data: $('#userform').serialize(),
                        url: "{{ route('usermanagement.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function (response) {
                            if (response.status) {
                                Swal.fire({
                                    title: response.message,
                                    type: 'success',
                                    timer: 2000,
                                    showConfirmButton: false,
                                    onAfterClose: () => {
                                        window.location="{{ route('usermanagement.index') }}";
                                    
                                    }
                                });
                            }
                        },
                        error: function (response) {
                            $('#saveBtn').html('Save Changes');
                        }
                    });
                }
                else{
                    location.reload();
                }
            });
        }
    });
</script>
@if(session('feedback'))
<script>
    Swal.fire(
        '{{ session(' feedback')}}', //
        'You clicked the button!',
        'success'
    )
</script>
@endif
@endsection

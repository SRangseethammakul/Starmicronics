@extends('layouts.backend')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
    <h1 class="m-0 text-dark">Role</h1>
    </div>
    <!-- /.content-header -->
    <section class="content" id="app">
        <div class="container">
            <form method="post" action="{{ route('role.store')}}" enctype="multipart/form-data">
            @csrf
                <div class="form-group">
                    <label for="role_name">ชื่อบทบาท</label>
                    <input type="text" class="form-control" id="role_name" name="role_name" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </section>
@endsection

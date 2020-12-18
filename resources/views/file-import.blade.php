@extends('layouts.backend')
@section('content')
    @if (isset($failures))
       <div class="alert alert-danger" role="alert">
          <strong>Errors:</strong>
          <ul>
             @foreach ($failures as $failure)
                @foreach ($failure->errors() as $error)
                    <li>{{ $error }}</li>
                @endforeach
             @endforeach
          </ul>
       </div>
    @endif
    <!-- Content Header (Page header) -->
    <div class="content-header">
    <h1 class="m-0 text-dark">Import Excel</h1>
    </div>
    <!-- /.content-header -->
    <br>
    <section class="content" id="app">
        <div class="container">
            <div class="mx-auto">
                <form action="{{ route('file-import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                        
                        <div class="custom-file text-left">
                            <div class="form-group">
                                <label for="customFile">Choose file</label>
                                <input type="file" class="form-control-file" id="customFile" name="file">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg btn-center">Import data</button>
                </form>
              </div>
        </div>
    </section>
@endsection

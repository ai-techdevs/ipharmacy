@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    Create Medicine
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Medicine</li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>

            </div>

        </div>
    </div>
</section>

<div class="content px-3">



    <div class="card">

        <form action="{{ route('admin.medicines.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">


                <input type="file" name="csv_file" required>




            </div>

            <div class="card-footer">

                <button type="submit">Upload CSV</button>
                <a href="{{ route('admin.medicines.index') }}" class="btn btn-default"> Cancel </a>
            </div>
            @if(session('success'))
            <p style="color:green">{{ session('success') }}</p>
            @endif
            @if(session('error'))
            <p style="color:red">{{ session('error') }}</p>
            @endif
        </form>

    </div>
</div>
@endsection

@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Edit Sub Admin
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Sub Admin</li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>

                </div>

            </div>
        </div>
    </section>

    <div class="content px-3">
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif


        <div class="card">

           <form action="{{ route('admin.sub-admin.update',  $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">

                <div class="row">
                    @include('admin.sub-admin.fields')
                </div>

            </div>

            <div class="card-footer">

                <button class="btn btn-primary" type="submit">Save</button>
                <a href="{{ route('admin.sub-admin.index') }}" class="btn btn-default"> Cancel </a>
            </div>

           </form>

        </div>
    </div>
@endsection


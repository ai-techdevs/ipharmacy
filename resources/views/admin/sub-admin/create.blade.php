@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                    Create Sub Admin
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Sub Admin</li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>

                </div>

            </div>
        </div>
    </section>

    <div class="content px-3">



        <div class="card">

           <form action="{{ route('admin.sub-admin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
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

@push('custom_js')

@endpush


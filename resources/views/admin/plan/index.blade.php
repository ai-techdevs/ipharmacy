@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Paypal Plan Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                        <li class="breadcrumb-item active">Paypal Plan Management</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <a class="btn btn-primary float-right"
                       href="{{ route('admin.plan.create') }}">
                        Add New
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @if (Session::has('success'))
            <div class="alert alert-success"><b>Success: </b>{{ Session::get('success') }}</div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger"><b>Error: </b> {{ Session::get('error') }}</div>
        @endif


        <div class="clearfix"></div>

        <div class="card">
            @include('admin.plan.table')
        </div>
    </div>

@endsection

@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>FAQ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                        <li class="breadcrumb-item active">FAQ</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <a class="btn btn-primary float-right"
                       href="{{ route('admin.faqs.create') }}">
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
            <div class="card-body px-4">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <th>Section Name</th>
                           {{--  <th>Title</th> --}}
                            <th>Description</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @if(!empty($datas))
                                @foreach ($datas as $data)
                                    <tr>
                                        <td>{{ $data->section_name }}</td>
                                       {{--  <td>{!! $data->section_title !!}</td> --}}
                                        <td>{{ $data->section_text }}</td>
                                        <td>
                                            <a href="{{ route('admin.home-page.edit', $data->id) }}" class="btn btn-default"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

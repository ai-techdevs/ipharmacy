@extends('admin.layouts.app')

@section('content')
    <section class="content-header">

        <div class="container-fluid">
            <div id="message">

            </div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        CDC Media Details
                    </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right" href="{{ route('admin.cdcs.index') }}">
                        Back
                    </a>
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
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="">Title<span class="text-danger"></span></label>
                        <p>{{ $cdc->title }}</p>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="">Author<span class="text-danger"></span></label>
                        <p>{{ $cdc->author }}</p>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="">Description<span class="text-danger"></span></label>
                        <p>{!! $cdc->description !!}</p>
                    </div>

                    @if (!empty($cdc->image))
                        <div class="form-group col-sm-6" id="imageField">
                            @if (is_file(public_path('storage/' . $cdc?->image)))
                                <img id="image{{ $cdc?->id }}" src="{{ url('storage/' . $cdc?->image) }}" alt=""
                                    height="80" width="90">
                            @endif
                        </div>
                    @endif

                    <div class="content px-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @include('admin.cdc.table')
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

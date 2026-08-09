@extends('admin.layouts.app')

@section('content')

    <section class="content-header">

        <div class="container-fluid">
            <div id="message">

            </div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Forum Details
                    </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right" href="{{ route('admin.forums.index') }}">
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
                    @include('admin.forums.fields')

                    <div class="content px-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @include('admin.forums.table')
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

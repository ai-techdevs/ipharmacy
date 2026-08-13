@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Synced CDC Posts</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Synced CDC Posts</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <form action="{{ route('admin.temp-cdc-posts.sync') }}" method="POST" class="float-right" id="sync-form">
                        @csrf
                        <button type="submit" class="btn btn-success" id="sync-btn">
                            <i class="fas fa-sync-alt mr-1"></i> Import CDC Posts
                        </button>
                    </form>
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
            @include('admin.temp_cdc_posts.table')
        </div>
    </div>

    <script>
        document.getElementById('sync-form').addEventListener('submit', function() {
            var btn = document.getElementById('sync-btn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Syncing...';
        });
    </script>
@endsection

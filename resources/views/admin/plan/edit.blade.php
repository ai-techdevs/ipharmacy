@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Edit Paypal Plans
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Plan</li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>

                </div>

            </div>
        </div>
    </section>

    <div class="content px-3">



        <div class="card">

           <form action="{{ route('admin.plan.update',  $role->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">

                <div class="row">
                    @include('admin.plan.fields')
                </div>

            </div>

            <div class="card-footer">

                <button class="btn btn-primary" type="submit">Save</button>
                <a href="{{ route('admin.plan.index') }}" class="btn btn-default"> Cancel </a>
            </div>

           </form>

        </div>
    </div>
@endsection


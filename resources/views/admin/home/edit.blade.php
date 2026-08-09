@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Edit Home Page
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Home Page</li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>

                </div>

            </div>
        </div>
    </section>

    <div class="content px-3">



        <div class="card">

           <form action="{{ route('admin.home-page.update',  $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
             <div class="card-body">

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="">Section Title<span class="text-danger">*</span></label>
                        <input type="text" name="section_title" value="{{ $data->section_title ?? ''}}" class="form-control" id="section_title" required>
                        @error('section_title')
                            <span class="text text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12">
                        <label for=""> Section Text<span class="text-danger">*</span></label>
                        <input type="text" name="section_text" value="{{ $data->section_text ?? ''}}" class="form-control" id="section_text" required>
                        @error('section_text')
                            <span class="text text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="card-footer">

                <button class="btn btn-primary" type="submit">Save</button>
                <a href="{{ route('admin.home-page.index') }}" class="btn btn-default"> Cancel </a>
            </div>

           </form>

        </div>
    </div>
@endsection


@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">

                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <div class="card">



            <div class="card-body">
                {{-- @include('flash::message') --}}
                @if (Session::has('success'))
                <div class="alert alert-success"><b>Success: </b>{{ Session::get('success') }}</div>
            @endif
        
            @if (Session::has('error'))
                <div class="alert alert-danger"><b>Error: </b> {{ Session::get('error') }}</div>
            @endif
                <div class="card-header">
                    <h5>Edit Settings</h5>
                </div>
                <div class="row">
                    <table class="table table-borderless">
                    <form action="{{ route('admin.settings.update',['setting' =>$setting->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        {{-- <input type="hidden" name="user" id="user" value="{{ $setting->id ?? "" }}"> --}}
                        <tr>
                           <td>{{strtoupper($setting->display_name) ?? ""}}</td>
                            <td>
                                @if($setting->type == "text")
                                     <input type="text" name="value" value="{{$setting->value}}" class="form-control" required>
                                @elseif($setting->type == "number")
                                     <input type="number" name="value" value="{{$setting->value}}" class="form-control" required step="any">
                                @elseif($setting->type == "textarea" || $setting->type == "rich_text_box")
                                    <textarea name="value" id="tinymce-editor" cols="40" rows="10" required>{{ $setting->value }}</textarea>
                                @elseif($setting->type == "image")
                                    <input type="hidden" name="fileType" value="file">
                                    <input type="file" name="image" class="form-control" required>
                                     @elseif($setting->type == "time")
                                     <input type="time" name="value" value="{{$setting->value}}" class="form-control" required step="1">
                                @endif
                                @error('value')
                                    <span class="text text-danger">{{ $message }}</span>
                                 @enderror
                             </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                 <button type="submit" class="btn btn-success">Save</button>
                             </td>
                        </tr>
                    </form>
                    </table>
                </div>

            </div>

            <div class="card-footer">
                <a href="{{ route('admin.settings.index') }}" class="btn btn-default">Cancel</a>
            </div>



        </div>
    </div>
@endsection
@push('custom_js')
    @if($setting->type == "rich_text_box")

        <script>
            $(document).ready(function(){
                $('#value').summernote({
                    height: 500,
                })
            })
        </script>
    @endif

@endpush

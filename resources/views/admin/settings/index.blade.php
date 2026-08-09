@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Settings</h1>
                </div>
                <div class="col-sm-6">

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

        {{-- @include('flash::message') --}}
        <div class="clearfix"></div>

        <div class="card">
            {{-- @include('flash::message') --}}

            <div class="clearfix"></div>
            <div class="card-body table-responsive">
                <table class="table table-sm">
                    <thead>
                        <th width="20%">Setting</th>
                        <th width="40%">Setting Value</th>
                        <th width="10%"></th>
                    </thead>
                    <tbody>
                        @if (!empty($settings))
                              @foreach ($settings as $setting)
                                  <tr>
                                    <td>{{ strtoupper($setting->display_name) ?? "" }}</td>
                                    <td>
                                        @if($setting->type == "image")
                                            <img src="{{ asset('storage/'. $setting->value )}}" alt="" height="50px" width="80px">
                                        @else
                                            {!! $setting->value ?? "" !!}
                                        @endif

                                    </td>
                                    <td>
                                        <a href="{{route('admin.settings.edit', ['setting'=> $setting->id]) }}" class="btn btn-default btn-xs">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </td>
                                  </tr>
                              @endforeach
                        @endif
                    </tbody>

                </table>

             {{-- {!! $dataTable->table() !!} --}}

            </div>

        </div>
       {{--  {!! $dataTable->scripts() !!} --}}
    </div>

@endsection


@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                    Create User
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">User</li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>

                </div>

            </div>
        </div>
    </section>

    <div class="content px-3">



        <div class="card">

           <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">

                <div class="row">
                    @include('user.fields')
                </div>

            </div>

            <div class="card-footer">

                <button class="btn btn-primary" type="submit">Save</button>
                <a href="{{ route('admin.user.index') }}" class="btn btn-default"> Cancel </a>
            </div>

           </form>

        </div>
    </div>
@endsection

@push('custom_js')
<script>
  function loadRolePermissions(roleId) {
      if(roleId == 4){
        $('#warehouse-field').css({'display':''}) ;
        $('#warehouse_id').attr("required", true);
      }else{
        $('#warehouse-field').css({'display':'none'}) ;
        $('#warehouse_id').attr("required", false);
      }
  }
</script>
@endpush


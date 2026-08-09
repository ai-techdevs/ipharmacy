<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Admin</title>

  <!-- Google Font: Source Sans Pro -->

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('/resources/admin/plugins/fontawesome-free/css/all.min.css')}}">

  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('resources/admin/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('resources/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('/resources/admin/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{url('assets/vendors/bootstrap/bootstrap.min.css')}}">
  <link rel="icon" type="image/x-icon" href="{{ url('assets/images/favicon.jpg')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <script src="{{ asset('assets/js/tinymce/tinymce/tinymce.min.js') }}"></script>

  <script>
    tinymce.init({
      selector: 'textarea.tinymce-editor', // Replace this CSS selector to match the placeholder element for TinyMCE
      plugins: 'code table lists',
      toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
    });
  </script>
  @stack('third_party_stylesheets')
  <link rel="stylesheet" href="{{url('assets/css/admin.css')}}">
</head>
<body class="hold-transition sidebar-mini">
    <style>
    .dataTables_length select {
        width: 120px !important;
    }
    </style>
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- <a target="_blank" href="#"><button class="btn btn-primary">Go To Website</button></a> -->

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <!-- <img src="https://assets.infyom.com/logo/blue_logo_150x150.png"
                     class="user-image img-circle elevation-2" alt="User Image"> -->
                <span class="d-none d-md-inline">{{Auth::user()?->name}}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                     {{-- <img src="https://assets.infyom.com/logo/blue_logo_150x150.png"
                         class="img-circle elevation-2"
                         alt="User Image"> --}}
                    <p>
                      ADMIN

                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                     <a href="{{route('admin.change.password')}}" class="btn btn-default btn-flat">Change Password</a>
                    <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat float-right"
                       >
                        Log out
                    </a>

                </li>
            </ul>
        </li>
    </ul>
</nav>
  <!-- /.navbar -->
    <!-- Main Sidebar Container -->
        @include('admin.layouts.sidebar')
    <!-- /.sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

      @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

   <!-- <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer> -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('/resources/admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('/resources/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- bs-custom-file-input -->
<script src="{{asset('/resources/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/resources/admin/dist/js/adminlte.min.js')}}"></script>

<!-- Select2 -->
<script src="{{asset('resources/admin/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Toastr CSS -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{asset('/resources/admin/dist/js/demo.js')}}"></script> --}}
<!-- Page specific script -->
<script>
    $(function () {
    $('[data-toggle="tooltip"]').tooltip();
    })
     //Initialize Select2 Elements
     $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4',
    })

    $(function () {
      bsCustomFileInput.init();

    });
    $('.js-example-basic-multiple').select2();
</script>
@stack('third_party_scripts')
@stack('custom_js')
</body>
</html>

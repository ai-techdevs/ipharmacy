<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> {{ env('APP_NAME') }} | Admin Log in</title>
<link rel="shortcut icon" href="{{ url('assets/images/favicon.jpg')}}" type="image/x-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('/resources/admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('/resources/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/resources/admin/dist/css/adminlte.min.css')}}">
  
  <style>
      .login-page .text-danger{
      display: block;
      width: 100%;
    }

  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">

     @if (Session::has('success'))
            <div class="alert alert-success"><b>Success: </b>{{ Session::get('success') }}</div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger"><b>Error: </b> {{ Session::get('error') }}</div>
        @endif
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{route('admin.login')}}" class="h1"><b>{{ env('APP_NAME') }}</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Password Recovery</p>

      <form action="{{route('admin.forget.password.post')}}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') border-danger @enderror" value="{{ old('email') }}" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          @error('email')
                <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        {{-- <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div> --}}
        <div class="row">
          <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
            <!-- <a class="btn btn-success" href="#">
              Register
            </a> -->
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

 <div class="form-group dont-have-account mt-1">
                                                            <h5>Back to login? <a id="dont_account_SignUp"
                                                                    href="{{route('admin.login')}}" data-tab="tab2">Click Here</a></h5>
                                                        </div>

<!-- jQuery -->
<script src="{{asset('/resources/admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('/resources/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/resources/admin/dist/js/adminlte.min.js')}}"></script>
<script>
    history.pushState(null, null, window.location.href);
    history.back();
    window.onpopstate = () => history.forward();
</script>
</body>
</html>

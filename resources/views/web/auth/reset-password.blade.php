<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ipharmacy</title>
    <!-- Bootstrap -->
    <link rel="shortcut icon" href="{{ url('assets/images/favicon.jpg')}}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- fontawesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"
        media="all">
    <!-- fontawesome -->
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="{{ url('assets/css/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/aos.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/menu.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/style.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/responsive.css') }}" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    {{-- {!! Toastr::css() !!} --}}
</head>

<body>
    {{-- {!! Toastr::js() !!} --}}
    {{-- {!! Toastr::message() !!} --}}
    <section class="login-register-body">
        <div class="login-register-wrapper">
            <div class="logo-wrap">
                <a href="{{ route('index') }}">
                    <img class="img-fluid" src="{{ url('assets/images/logo.png') }}" alt="">
                </a>
            </div>
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6">
                        <div class="login-register-form-wrap">
                            <div class="login-register-nav mb-5">
                                {{-- <ul class="nav nav-tabs" id="logregNav">
                    <li class="nav-item">
                      <a class="nav-link active" href="#" data-tab="tab1">Login</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#" data-tab="tab2">Signup</a>
                    </li>
                  </ul> --}}
                                
                            </div>
                            @if (Session::has('success'))
                                <div class="alert alert-success"><b>Success:
                                    </b>{{ Session::get('success') }}</div>
                            @endif

                            @if (Session::has('error'))
                                <div class="alert alert-danger"><b>Error: </b> {{ Session::get('error') }}
                                </div>
                            @endif

                            <div class="tab-content" id="tabContentOne">
                                {{-- <div class="tab-pane fade"
                                    id="tab1-pane-1"> --}}
                                    <!-- Login form -->
                                    <div class="login-register-form">
                                        <div class="title mb-4">
                                            <h3> Reset Password</h3>
                                            <p>Enter your email address and new password .</p>
                                        </div>
                                        <form action="{{route('reset.password.post')}}" method="POST">
                                            @csrf
                                            <div class="login-register-form-inner">
                                                <div class="row">
                                                    <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <label>Email </label>
                                                            <input class="form-control" type="email"
                                                                placeholder="youremail@gmail.com" name="email" value="{{old('email')}}"/>
                                                                 @error('email')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                     <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <label>New Password</label>
                                                            <div class="password-input">
                                                                <input class="form-control" type="password"
                                                                    name="password" />
                                                                     @error('password')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                                <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                     <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <label>Confirm Password</label>
                                                            <div class="password-input">
                                                                <input class="form-control" type="password"
                                                                    name="password_confirmation" />
                                                                     @error('password_confirmation')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                                <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="token" value="{{ $token }}">
                                                    <div class="col-12 mb-5">
                                                        <div class="form-group forgot-pass">
                                                            <h5><a href="{{route('login')}}">Back to login?</a></h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <input class="btn common-btn2" type="submit"
                                                                value="Submit" />
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group dont-have-account">
                                                            <h5>Don’t have an account? <a id="dont_account_SignUp"
                                                                    href="{{route('registration')}}" data-tab="tab2">SignUp</a></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                               
                            {{-- </div> --}}

                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="login-register-right-img">
                            <!-- Second Tab Content Set -->
                            <div class="tab-content" id="tabContentTwo">
                                <div class="tab-pane fade show active" id="tab1-pane-2">
                                    <img class="img-fluid" src="{{ url('assets/images/login-img1.png') }}"
                                        alt="">
                                </div>
                                <div class="tab-pane fade" id="tab2-pane-2">
                                    <img class="img-fluid" src="{{ url('assets/images/register-img1.png') }}"
                                        alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="{{ url('assets/js/slick.min.js') }}"></script>
    <script src="{{ url('assets/js/aos.js') }}"></script>
    <script src="{{ url('assets/js/menu.js') }}"></script>
    <script src="{{ url('assets/js/external.js') }}"></script>
    <script>
        document.querySelectorAll('#logregNav .nav-link').forEach(el => {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                const targetUrl = this.getAttribute('href');
                // Update URL without reload
                history.pushState(null, '', targetUrl);
                // Manually activate tab based on href
                const isSignup = targetUrl.includes('registration');
                document.querySelectorAll('#logregNav .nav-link').forEach(n => n.classList.remove(
                    'active'));
                this.classList.add('active');

                document.getElementById('tab1-pane-1').classList.remove('show', 'active');
                document.getElementById('tab2-pane-1').classList.remove('show', 'active');

                if (isSignup) {
                    document.getElementById('tab2-pane-1').classList.add('show', 'active');
                } else {
                    document.getElementById('tab1-pane-1').classList.add('show', 'active');
                }
            });
        });

        // Handle back/forward navigation
        window.addEventListener('popstate', () => {
            const path = location.pathname;
            const isSignup = path.includes('registration');
            document.querySelectorAll('#logregNav .nav-link').forEach(n => n.classList.remove('active'));
            if (isSignup) {
                document.querySelector('#logregNav .nav-link[href$="registration"]').classList.add('active');
                document.getElementById('tab2-pane-1').classList.add('show', 'active');
                document.getElementById('tab1-pane-1').classList.remove('show', 'active');
            } else {
                document.querySelector('#logregNav .nav-link[href$="login"]').classList.add('active');
                document.getElementById('tab1-pane-1').classList.add('show', 'active');
                document.getElementById('tab2-pane-1').classList.remove('show', 'active');
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {!! \Brian2694\Toastr\Facades\Toastr::message() !!}

    {{-- <script type="text/javascript">
    $('#contactUSForm').submit(function(event) {
        event.preventDefault();
    
        grecaptcha.ready(function() {
            grecaptcha.execute("{{ env('NOCAPTCHA_SITEKEY') }}", {action: 'subscribe_newsletter'}).then(function(token) {
                $('#contactUSForm').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                $('#contactUSForm').unbind('submit').submit();
            });;
        });
    });
</script> --}}
    {{-- {!! NoCaptcha::renderJs() !!} --}}
</body>

</html>

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
     <link href="{{ url('assets/css/style.css') }}?v=1.0.6" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/responsive.css') }}" rel="stylesheet" media="all">

</head>

<body>

    <section class="user-dashboard-wrapper">
        <div class="user-dashboard-inner-wrap">
            <div class="dashboard-sidebar">
                <div class="db-sidebar-inner">
                    <div class="logo-wrap">
                        <a href="{{ route('index') }}">
                            <img class="img-fluid" src="{{ url('assets/images/logo.png') }}" alt="">
                        </a>
                    </div>
                    <div class="db-menu-wrap">
                        <ul>
                            <li class="active">
                                <a href="{{ route('dashboard') }}"> <span class="icon"> <img class="img-fluid"
                                            src="{{ asset('assets/images/db-dashboard-home.svg') }}" alt="">
                                    </span> Dashboard</a>
                            </li>
                            <li>
                                <a href="{{ route('drugs.info') }}"> <span class="icon"> <img class="img-fluid"
                                            src="{{ asset('assets/images/db-drug-information-icon.svg') }}"
                                            alt=""> </span> Drug Information</a>
                            </li>
                            <li>
                                <a href="{{ route('forum') }}"> <span class="icon"> <img class="img-fluid"
                                            src="{{ asset('assets/images/db-forum-icon.svg') }}" alt="">
                                    </span> Forum</a>
                            </li>
                            <li>
                                <a href="{{ route('media') }}"> <span class="icon"> <img class="img-fluid"
                                            src="{{ asset('assets/images/db-cdc-media-icon.svg') }}" alt="">
                                    </span> CDC Media</a>
                            </li>
                            <li>
                                <a href="{{ route('faq') }}"> <span class="icon"> <img class="img-fluid"
                                            src="{{ asset('assets/images/db-faqs-icon.svg') }}" alt=""> </span>
                                    FAQs</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="logout-btn-wrap">

                     <a href="{{route('index')}}" class="logout-btn"
                    >
                        <i class="fa-solid fa-arrow-right"></i> Go to Home
                    </a>
                  

                </div>
            </div>
            <div class="dashboard-body">
                <div class="db-header-wrapper">
                    <div class="header-left-search">
                        <div class="db-head-search">
                            <form>
                                <div class="search-box-inner">
                                    <div class="search-btn-wrp">
                                        <button class="search-btn" type="submit"><i
                                                class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                    <div class="search-box">
                                        <input class="form-control" type="search" name=""
                                            placeholder="Search drug information...">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="user-notification-wrap">
                        <ul class="user-notification-inner">
                            {{-- <li class="notification-wrap">
                                <a href="#" class="notification-btn">
                                    <i class="fa-regular fa-bell"></i>
                                </a>
                            </li> --}}
                            <li class="user-dropdown">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="user-img">
                                            @if (is_file(public_path('storage/' . auth()->user()?->image)))
                                                        
                                                            <img class="img-fluid"
                                                                src="{{ url('storage/' . auth()->user()?->image) }}"
                                                                alt="">
                                                       
                                                    @else
                                                        
                                                            <img class="img-fluid"
                                                                src="{{ url('default-profile.jpg') }}"
                                                                alt="">
                                                        
                                                    @endif
                                        </span>
                                        <div class="user-details">
                                            <h5>{{ auth()->user()->name }} {{ auth()->user()->last_name }}</h5>
                                            <p>Customer</p>
                                        </div>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="{{ route('profile') }}">Account
                                                Setting</a></li>
                                                <li>
    <a class="dropdown-item" href="{{ route('password.change') }}">
        Change Password
    </a>
</li>
                                                 <li><a class="dropdown-item" href="{{ route('subscription.list') }}">Donations</a></li>
                                        <li> <a href="#" class="dropdown-item"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Log out
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <button class="sidebar-tigger">
                                    <i class="fa-solid fa-bars"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="db-body-inner">
                    <div class="row">
                        <div class="col-12">
                            <div class="account-setting-wrap">
    <h3>Change Password</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('password.update') }}" method="POST" class="login-register-form">
        @csrf

        <div class="account-setting-form-wrap">
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <div class="form-group">
                        <label>Current Password<sup>*</sup></label>
                        <div class="password-input">
                        <input name="current_password" class="form-control" type="password">
                        @error('current_password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                         <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                         </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <div class="form-group">
                        <label>New Password<sup>*</sup></label>
                        <div class="password-input">
                        <input name="password" class="form-control" type="password">
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                         <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                         </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <div class="form-group">
                        <label>Confirm New Password<sup>*</sup></label>
                        <div class="password-input">
                        <input name="password_confirmation" class="form-control" type="password">
                         <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                         </div>
                    </div>
                </div>

                <div class="col-12 col-md-8">
                    <div class="form-btn-wrap">
                        <ul>
                            <li>
                                <button class="btn discard-btn" type="reset">Discard</button>
                            </li>
                            <li>
                                <button class="btn common-btn2" type="submit">Update Password</button>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- share social media -->
    <div class="modal fade share-social-modal-wrap" id="ShareSocialModal" tabindex="-1"
        aria-labelledby="ShareSocialLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa-solid fa-xmark"></i></button>
                <div class="modal-body">
                    <div class="title">
                        <h3>Share</h3>
                    </div>
                    <div class="social-media-wrap">
                        <ul>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="{{ url('assets/images/social-icon-facebook.png') }}"
                                        alt="">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="{{ url('assets/images/social-icon-email.png') }}"
                                        alt="">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="{{ url('assets/images/social-icon-twitter.png') }}"
                                        alt="">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="{{ url('assets/images/social-icon-linkedin.png') }}"
                                        alt="">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="{{ url('assets/images/social-icon-whatsapp.png') }}"
                                        alt="">
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img class="img-fluid" src="{{ url('assets/images/social-icon-wechat.png') }}"
                                        alt="">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ url('assets/js/slick.min.js') }}"></script>
    <script src="{{ url('assets/js/aos.js') }}"></script>
    <script src="{{ url('assets/js/menu.js') }}"></script>
    <script src="{{ url('assets/js/external.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const fileInput = document.getElementById("file-input");
            const previewImg = document.getElementById("profilePreview");

            fileInput.addEventListener("change", function(event) {
                if (event.target.files && event.target.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                    };
                    reader.readAsDataURL(event.target.files[0]);
                }
            });
        });
    </script>
</body>

</html>

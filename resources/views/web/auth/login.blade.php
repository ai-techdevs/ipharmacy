<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ipharmacy</title>
    <!-- Bootstrap -->
    <link rel="shortcut icon" href="{{ url('assets/images/favicon.jpg') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- fontawesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" media="all">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
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
                <a class="navbar-brand" href="{{route('index')}}">
                    <img class="img-fluid" src="{{ url('assets/images/logo.png') }}" alt="">
                </a>
            </div>
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 offset-md-3">
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
                                <ul class="nav nav-tabs" id="logregNav">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'login' ? 'active' : '' }}" href="{{ route('login') }}" data-tab="tab1">Login</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab === 'signup' ? 'active' : '' }}" href="{{ route('registration') }}" data-tab="tab2">Signup</a>
                                    </li>
                                </ul>
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
                                <div class="tab-pane fade {{ $activeTab === 'login' ? 'show active' : '' }}" id="tab1-pane-1">
                                    <!-- Login form -->
                                    <div class="login-register-form">
                                        <div class="title mb-4">
                                            <h3>Log in to your account</h3>
                                            <p>Enter your email address and password to log in.</p>
                                        </div>
                                        <form action="{{ route('doLogin') }}" method="POST">
                                            @csrf
                                            <div class="login-register-form-inner">
                                                <div class="row">
                                                    <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <label>Email<sup>*</sup> </label>
                                                            <input class="form-control" type="email" placeholder="youremail@gmail.com" name="email" />
                                                            @error('email')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <label>Password<sup>*</sup></label>
                                                            <div class="password-input">
                                                                <input class="form-control" type="password" name="password" />
                                                                @error('password')
                                                                <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                                <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-5">
                                                        <div class="form-group forgot-pass">
                                                            <h5><a href="{{ route('forget.password') }}">Forgot
                                                                    Password?</a></h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <input class="btn common-btn2" type="submit" value="Login" />
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group dont-have-account">
                                                            <h5>Don’t have an account? <a id="dont_account_SignUp" href="{{ route('registration') }}" data-tab="tab2">SignUp</a></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ $activeTab === 'signup' ? 'show active' : '' }}" id="tab2-pane-1">

                                    <div class="login-register-form">
                                        <div class="title mb-4">
                                            <h3>Create your account</h3>
                                            <p>Enter your fields below to get started</p>
                                        </div>


                                        <form action="{{ route('doRegistration') }}" method="POST" id="contactUSForm">
                                            @csrf
                                            <div class="login-register-form-inner">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 mb-4">
                                                        <div class="form-group">
                                                            <label>First Name<sup>*</sup></label>
                                                            <input name="first_name" class="form-control" type="text" placeholder="Alexiya" value="{{ old('first_name') }}" />
                                                            @error('first_name')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-4">
                                                        <div class="form-group">
                                                            <label>Last Name<sup>*</sup></label>
                                                            <input name="last_name" class="form-control" type="text" placeholder="Johnson" value="{{ old('last_name') }}" />
                                                            @error('last_name')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <label>Email<sup>*</sup> </label>
                                                            <input name="email" class="form-control" type="email" placeholder="youremail@gmail.com" value="{{ old('email') }}" />
                                                            @error('email')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <label>Mobile<sup>*</sup> </label>
                                                            <input name="mobile" id="mobile" class="form-control" type="text" placeholder="### - ### - ####" value="{{ old('mobile') }}" />
                                                            @error('mobile')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-4">
                                                        <div class="form-group">
                                                            <label>Age Group<sup>*</sup></label>
                                                            <select name="age_group" class="form-select">
                                                                <option value="">Select</option>
                                                                <option value="18-30" {{ old('age_group') == '18-30' ? 'selected' : '' }}>
                                                                    18-30
                                                                </option>
                                                                <option value="31-45" {{ old('age_group') == '31-45' ? 'selected' : '' }}>
                                                                    31-45
                                                                </option>
                                                                <option value="46-60" {{ old('age_group') == '46-60' ? 'selected' : '' }}>
                                                                    46-60
                                                                </option>
                                                                <option value="60+" {{ old('age_group') == '60+' ? 'selected' : '' }}>
                                                                    60+
                                                                </option>
                                                            </select>
                                                            @error('age_group')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-4">
                                                        <div class="form-group">
                                                            <label>Gender<sup>*</sup></label>
                                                            <select name="gender" class="form-select">
                                                                <option value="">Select</option>
                                                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                                                    Male
                                                                </option>
                                                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                                    Female
                                                                </option>
                                                                {{-- <option value="others"
                                                                    {{ old('gender') == 'others' ? 'selected' : '' }}>
                                                                Others
                                                                </option> --}}
                                                            </select>
                                                            @error('gender')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <label>Address 1<sup>*</sup> </label>
                                                            <textarea name="address1" class="form-control" placeholder="your address*" rows="3">{{ old('address1') }}</textarea>
                                                            @error('address1')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <label>Address 2 </label>
                                                            <textarea name="address2" class="form-control" placeholder="your address*" rows="3">{{ old('address2') }}</textarea>
                                                            @error('address2')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-4">
                                                        <div class="form-group">
                                                            <label>City<sup>*</sup></label>
                                                            <input name="city" class="form-control" type="text" placeholder="City" value="{{ old('city') }}" />
                                                            @error('city')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-4">
                                                        <div class="form-group">
                                                            <label>State<sup>*</sup></label>
                                                            {{-- <select name="state" class="form-select">
                                                                <option value="">Select</option>
                                                                <option value="USA"
                                                                    {{ old('state') == 'USA' ? 'selected' : '' }}>USA
                                                            </option>
                                                            <option value="India" {{ old('state') == 'India' ? 'selected' : '' }}>
                                                                India
                                                            </option>
                                                            <option value="UK" {{ old('state') == 'UK' ? 'selected' : '' }}>UK
                                                            </option>
                                                            </select> --}}
                                                            <select name="state" class="form-select">
                                                                <option value="">Select State</option>
                                                                <option value="AL" {{ old('state') == 'AL' ? 'selected' : '' }}>
                                                                    Alabama (AL)</option>
                                                                <option value="AK" {{ old('state') == 'AK' ? 'selected' : '' }}>Alaska
                                                                    (AK)</option>
                                                                <option value="AZ" {{ old('state') == 'AZ' ? 'selected' : '' }}>
                                                                    Arizona (AZ)</option>
                                                                <option value="AR" {{ old('state') == 'AR' ? 'selected' : '' }}>
                                                                    Arkansas (AR)</option>
                                                                <option value="CA" {{ old('state') == 'CA' ? 'selected' : '' }}>
                                                                    California (CA)</option>
                                                                <option value="CO" {{ old('state') == 'CO' ? 'selected' : '' }}>
                                                                    Colorado (CO)</option>
                                                                <option value="CT" {{ old('state') == 'CT' ? 'selected' : '' }}>
                                                                    Connecticut (CT)</option>
                                                                <option value="DE" {{ old('state') == 'DE' ? 'selected' : '' }}>
                                                                    Delaware (DE)</option>
                                                                <option value="FL" {{ old('state') == 'FL' ? 'selected' : '' }}>
                                                                    Florida (FL)</option>
                                                                <option value="GA" {{ old('state') == 'GA' ? 'selected' : '' }}>
                                                                    Georgia (GA)</option>
                                                                <option value="HI" {{ old('state') == 'HI' ? 'selected' : '' }}>Hawaii
                                                                    (HI)</option>
                                                                <option value="ID" {{ old('state') == 'ID' ? 'selected' : '' }}>Idaho
                                                                    (ID)</option>
                                                                <option value="IL" {{ old('state') == 'IL' ? 'selected' : '' }}>
                                                                    Illinois (IL)</option>
                                                                <option value="IN" {{ old('state') == 'IN' ? 'selected' : '' }}>
                                                                    Indiana (IN)</option>
                                                                <option value="IA" {{ old('state') == 'IA' ? 'selected' : '' }}>Iowa
                                                                    (IA)</option>
                                                                <option value="KS" {{ old('state') == 'KS' ? 'selected' : '' }}>Kansas
                                                                    (KS)</option>
                                                                <option value="KY" {{ old('state') == 'KY' ? 'selected' : '' }}>
                                                                    Kentucky (KY)</option>
                                                                <option value="LA" {{ old('state') == 'LA' ? 'selected' : '' }}>
                                                                    Louisiana (LA)</option>
                                                                <option value="ME" {{ old('state') == 'ME' ? 'selected' : '' }}>Maine
                                                                    (ME)</option>
                                                                <option value="MD" {{ old('state') == 'MD' ? 'selected' : '' }}>
                                                                    Maryland (MD)</option>
                                                                <option value="MA" {{ old('state') == 'MA' ? 'selected' : '' }}>
                                                                    Massachusetts (MA)</option>
                                                                <option value="MI" {{ old('state') == 'MI' ? 'selected' : '' }}>
                                                                    Michigan (MI)</option>
                                                                <option value="MN" {{ old('state') == 'MN' ? 'selected' : '' }}>
                                                                    Minnesota (MN)</option>
                                                                <option value="MS" {{ old('state') == 'MS' ? 'selected' : '' }}>
                                                                    Mississippi (MS)</option>
                                                                <option value="MO" {{ old('state') == 'MO' ? 'selected' : '' }}>
                                                                    Missouri (MO)</option>
                                                                <option value="MT" {{ old('state') == 'MT' ? 'selected' : '' }}>
                                                                    Montana (MT)</option>
                                                                <option value="NE" {{ old('state') == 'NE' ? 'selected' : '' }}>
                                                                    Nebraska (NE)</option>
                                                                <option value="NV" {{ old('state') == 'NV' ? 'selected' : '' }}>Nevada
                                                                    (NV)</option>
                                                                <option value="NH" {{ old('state') == 'NH' ? 'selected' : '' }}>New
                                                                    Hampshire (NH)</option>
                                                                <option value="NJ" {{ old('state') == 'NJ' ? 'selected' : '' }}>New
                                                                    Jersey (NJ)</option>
                                                                <option value="NM" {{ old('state') == 'NM' ? 'selected' : '' }}>New
                                                                    Mexico (NM)</option>
                                                                <option value="NY" {{ old('state') == 'NY' ? 'selected' : '' }}>New
                                                                    York (NY)</option>
                                                                <option value="NC" {{ old('state') == 'NC' ? 'selected' : '' }}>North
                                                                    Carolina (NC)</option>
                                                                <option value="ND" {{ old('state') == 'ND' ? 'selected' : '' }}>North
                                                                    Dakota (ND)</option>
                                                                <option value="OH" {{ old('state') == 'OH' ? 'selected' : '' }}>Ohio
                                                                    (OH)</option>
                                                                <option value="OK" {{ old('state') == 'OK' ? 'selected' : '' }}>
                                                                    Oklahoma (OK)</option>
                                                                <option value="OR" {{ old('state') == 'OR' ? 'selected' : '' }}>Oregon
                                                                    (OR)</option>
                                                                <option value="PA" {{ old('state') == 'PA' ? 'selected' : '' }}>
                                                                    Pennsylvania (PA)</option>
                                                                <option value="RI" {{ old('state') == 'RI' ? 'selected' : '' }}>Rhode
                                                                    Island (RI)</option>
                                                                <option value="SC" {{ old('state') == 'SC' ? 'selected' : '' }}>South
                                                                    Carolina (SC)</option>
                                                                <option value="SD" {{ old('state') == 'SD' ? 'selected' : '' }}>South
                                                                    Dakota (SD)</option>
                                                                <option value="TN" {{ old('state') == 'TN' ? 'selected' : '' }}>
                                                                    Tennessee (TN)</option>
                                                                <option value="TX" {{ old('state') == 'TX' ? 'selected' : '' }}>Texas
                                                                    (TX)</option>
                                                                <option value="UT" {{ old('state') == 'UT' ? 'selected' : '' }}>Utah
                                                                    (UT)</option>
                                                                <option value="VT" {{ old('state') == 'VT' ? 'selected' : '' }}>
                                                                    Vermont (VT)</option>
                                                                <option value="VA" {{ old('state') == 'VA' ? 'selected' : '' }}>
                                                                    Virginia (VA)</option>
                                                                <option value="WA" {{ old('state') == 'WA' ? 'selected' : '' }}>
                                                                    Washington (WA)</option>
                                                                <option value="WV" {{ old('state') == 'WV' ? 'selected' : '' }}>West
                                                                    Virginia (WV)</option>
                                                                <option value="WI" {{ old('state') == 'WI' ? 'selected' : '' }}>
                                                                    Wisconsin (WI)</option>
                                                                <option value="WY" {{ old('state') == 'WY' ? 'selected' : '' }}>
                                                                    Wyoming (WY)</option>

                                                                <!-- U.S. Territories -->
                                                                <option value="DC" {{ old('state') == 'DC' ? 'selected' : '' }}>
                                                                    District of Columbia (DC)</option>
                                                                <option value="AS" {{ old('state') == 'AS' ? 'selected' : '' }}>
                                                                    American Samoa (AS)</option>
                                                                <option value="GU" {{ old('state') == 'GU' ? 'selected' : '' }}>Guam
                                                                    (GU)</option>
                                                                <option value="MP" {{ old('state') == 'MP' ? 'selected' : '' }}>
                                                                    Northern Mariana Islands (MP)</option>
                                                                <option value="PR" {{ old('state') == 'PR' ? 'selected' : '' }}>Puerto
                                                                    Rico (PR)</option>
                                                                <option value="VI" {{ old('state') == 'VI' ? 'selected' : '' }}>U.S.
                                                                    Virgin Islands (VI)</option>
                                                            </select>
                                                            @error('state')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 mb-4">
                                                        <div class="form-group">
                                                            <label>Zip<sup>*</sup></label>
                                                            <input name="zip" class="form-control" type="text" placeholder="Zip" value="{{ old('zip') }}" />
                                                            @error('zip')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 mb-4">
                                                        <div class="form-group">
                                                            <label>Password<sup>*</sup></label>
                                                            <div class="password-input">
                                                            <input name="password" class="form-control" type="password" />
                                                            @error('password')
                                                            <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                             <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                                                             
                                                             </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-4">
                                                        <div class="form-group">
                                                            <label>Confirm Password<sup>*</sup></label>
                                                            <div class="password-input">
                                                            <input name="password_confirmation" class="form-control" type="password" />
                                                             <i class="toggle-password fa fa-fw fa-eye-slash"></i></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-5">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input name="terms" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" {{ old('terms') ? 'checked' : '' }}>

                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    I’m agree to the <a href="{{route('terms')}}">Terms of
                                                                        Use</a> and <a href="{{route('privacy')}}">Privacy
                                                                        Policy</a>
                                                                </label>
                                                                @error('terms')
                                                                <div class="text-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-12 mb-5">
                                                        {{-- @error('g-recaptcha-response')
                                                                <span class="text-danger">{{ $message }}</span>
                                                        @enderror --}}
                                                        <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>
                                                        @error('g-recaptcha-response')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                        {{-- <div class="form-group">
                                                            {!! NoCaptcha::display() !!}
                                                            @error('g-recaptcha-response')
                                                                <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div> --}}
                                                </div>

                                                <div class="col-12 mb-4">
                                                    <div class="form-group">
                                                        <input class="btn common-btn2" type="submit" value="Sign Up" />
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group dont-have-account">
                                                        <h5>Already have an account? <a href="{{ route('login') }}" id="have_account_Login" data-tab="tab2">Login</a>
                                                        </h5>
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
                <div class="col-12 col-md-6 d-none">
                    <div class="login-register-right-img">
                        <!-- Second Tab Content Set -->
                        <div class="tab-content" id="tabContentTwo">
                            <div class="tab-pane fade show active" id="tab1-pane-2">
                                <img class="img-fluid" src="{{ url('assets/images/login-img1.png') }}" alt="">
                            </div>
                            <div class="tab-pane fade" id="tab2-pane-2">
                                <img class="img-fluid" src="{{ url('assets/images/register-img1.png') }}" alt="">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contactUSForm');
            const fields = form.querySelectorAll('input, select, textarea');
            const captchaSiteKey = "{{ env('NOCAPTCHA_SITEKEY') }}"; // your site key

            // Validation rules
            const validators = {
                first_name: value => value.trim() !== '' ? '' : 'First name is required'
                , last_name: value => value.trim() !== '' ? '' : 'Last name is required'
                , email: value => {
                    if (value.trim() === '') return 'Email is required';
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return emailRegex.test(value) ? '' : 'Enter a valid email';
                }
                , mobile: value => value.trim() !== '' ? '' : 'Mobile number is required'
                , age_group: value => value !== '' ? '' : 'Select age group'
                , gender: value => value !== '' ? '' : 'Select gender'
                , address1: value => value.trim() !== '' ? '' : 'Address 1 is required'
                , city: value => value.trim() !== '' ? '' : 'City is required'
                , state: value => value !== '' ? '' : 'Select state'
                , zip: value => value.trim() !== '' ? '' : 'Zip code is required'
                , password: value => value.trim() !== '' ? '' : 'Password is required'
                , password_confirmation: value => {
                    const pwd = form.querySelector('input[name="password"]').value;
                    if (value.trim() === '') return 'Confirm your password';
                    return value === pwd ? '' : 'Passwords do not match';
                }
                , terms: el => el.checked ? '' : 'You must agree to terms'
            };

            // Show error
            function showError(field, message) {
                removeError(field);
                if (!message) return;
                const errorDiv = document.createElement('div');
                errorDiv.className = 'field-error-message';
                errorDiv.style.color = '#dc3545';
                errorDiv.style.fontSize = '12px';
                errorDiv.style.marginTop = '4px';
                errorDiv.textContent = message;

                // Insert error inside parent .form-group
                const formGroup = field.closest('.form-group');
                formGroup.appendChild(errorDiv);

                field.style.borderColor = '#dc3545';
            }

            // Remove error
            function removeError(field) {
                const formGroup = field.closest('.form-group');
                const existing = formGroup.querySelector('.field-error-message');
                if (existing) existing.remove();
                field.style.borderColor = '';
            }

            // Validate a single field
            function validateField(field) {
                const name = field.name;
                if (!validators[name]) return true;
                let message = '';
                if (name === 'terms') {
                    message = validators[name](field);
                } else {
                    message = validators[name](field.value);
                }
                showError(field, message);
                return message === '';
            }

            // Validate reCAPTCHA
            function validateCaptcha() {
                const response = grecaptcha.getResponse();
                const captchaDiv = document.querySelector('.g-recaptcha');
                const existingError = captchaDiv.querySelector('.field-error-message');
                if (existingError) existingError.remove();

                if (response.length === 0) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'field-error-message';
                    errorDiv.style.color = '#dc3545';
                    errorDiv.style.fontSize = '12px';
                    errorDiv.style.marginTop = '4px';
                    errorDiv.textContent = 'Please complete the captcha';
                    captchaDiv.appendChild(errorDiv);
                    return false;
                }
                return true;
            }

            // Attach focusout event
            fields.forEach(field => {
                field.addEventListener('focusout', () => validateField(field));
            });

            // Validate all on submit
            form.addEventListener('submit', function(e) {
                let isValid = true;
                fields.forEach(field => {
                    if (!validateField(field)) isValid = false;
                });

                if (!validateCaptcha()) isValid = false;

                if (!isValid) e.preventDefault(); // prevent submission if invalid
            });
        });

    </script>
    <script>
        document.getElementById('mobile').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, "");
            let formatted = "";

            if (value.length > 0) {
                formatted = value.substring(0, 3);
            }
            if (value.length > 3) {
                formatted += " - " + value.substring(3, 6);
            }
            if (value.length > 6) {
                formatted += " - " + value.substring(6, 10);
            }

            e.target.value = formatted;
        });

    </script>
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

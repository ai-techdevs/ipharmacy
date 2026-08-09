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
                                <h3>Account Setting</h3>
                                <form action="{{ route('profile.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="account-profile-picture-change">
                                        <div class="account-profile-picname">
                                            <div class="profile-img">
                                                <img id="profilePreview" class="img-fluid"
                                                    src="{{ is_file(public_path('storage/' . auth()->user()?->image))
                                                        ? url('storage/' . auth()->user()?->image)
                                                        : url('default-profile.jpg') }}"
                                                    alt="Profile Image">
                                            </div>
                                            <div class="profile-name">
                                                <h5>{{ auth()->user()->name }} {{ auth()->user()->last_name }}</h5>
                                                <p>Customer</p>
                                            </div>
                                        </div>

                                        <div class="picture-change-btn">
                                            <div class="file-input">
                                                <input type="file" name="image" id="file-input"
                                                    class="file-input__input" accept="image/*" />
                                                <label class="file-input__label" for="file-input">
                                                    <span>Upload Image</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="account-setting-form-wrap">
                                        <div class="row">
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label>First Name<sup>*</sup></label>
                                                    <input name="first_name" class="form-control" type="text"
                                                        placeholder="Alexiya" value="{{ auth()->user()->name }}" />
                                                    @error('first_name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label>Last Name<sup>*</sup></label>
                                                    <input name="last_name" class="form-control" type="text"
                                                        placeholder="Johnson"
                                                        value="{{ auth()->user()->last_name }}" />
                                                    @error('last_name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label>Email<sup>*</sup></label>
                                                    <input name="email" class="form-control" type="email"
                                                        placeholder="youremail@gmail.com"
                                                        value="{{ auth()->user()->email }}" />
                                                    @error('email')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label>Mobile<sup>*</sup></label>
                                                    <input name="mobile" class="form-control" type="text"
                                                        placeholder="+1 458-569-568"
                                                        value="{{ auth()->user()->mobile }}" />
                                                    @error('mobile')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label>Age Group<sup>*</sup></label>
                                                    <select class="form-select" name="age_group">
                                                        <option value="18-30"
                                                            {{ old('age_group') == '18-30' || auth()->user()->age_group == '31-40' ? 'selected' : '' }}>
                                                            18-30</option>
                                                        <option value="31-45"
                                                            {{ old('age_group') == '31-45' || auth()->user()->age_group == '31-40' ? 'selected' : '' }}>
                                                            31-45</option>
                                                        <option value="46-60"
                                                            {{ old('age_group') == '46-60' || auth()->user()->age_group == '31-40' ? 'selected' : '' }}>
                                                            46-60</option>
                                                        <option value="60+"
                                                            {{ old('age_group') == '60+' || auth()->user()->age_group == '60+' ? 'selected' : '' }}>
                                                            60+</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label>Gender<sup>*</sup></label>
                                                    <select name="gender" class="form-select">
                                                        <option value="">Select</option>
                                                        <option value="male"
                                                            {{ old('gender') == 'male' || auth()->user()->gender == 'male' ? 'selected' : '' }}>
                                                            Male
                                                        </option>
                                                        <option value="female"
                                                            {{ old('gender') == 'female' || auth()->user()->gender == 'female' ? 'selected' : '' }}>
                                                            Female
                                                        </option>
                                                        <option value="others"
                                                            {{ old('gender') == 'others' || auth()->user()->gender == 'others' ? 'selected' : '' }}>
                                                            Others
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label>Address 1<sup>*</sup></label>
                                                    <textarea name="address1" class="form-control" placeholder="your address*" rows="3">{{ auth()->user()->address1 }}</textarea>
                                                    @error('address1')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label>Address 2</label>
                                                    <textarea name="address2" class="form-control" placeholder="your address*" rows="3">{{ auth()->user()->address2 }}</textarea>
                                                    @error('address2')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label>City<sup>*</sup></label>
                                                    <input name="city" class="form-control" type="text"
                                                        placeholder="City" value="{{ auth()->user()->city }}" />
                                                    @error('city')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label>State<sup>*</sup></label>
                                                    @php
    $selectedState = old('state') ?? (auth()->check() ? auth()->user()->state : '');
@endphp
                                                 <select name="state" class="form-select">
    <option value="">Select State</option>

    <option value="AL" {{ $selectedState == 'AL' ? 'selected' : '' }}>Alabama (AL)</option>
    <option value="AK" {{ $selectedState == 'AK' ? 'selected' : '' }}>Alaska (AK)</option>
    <option value="AZ" {{ $selectedState == 'AZ' ? 'selected' : '' }}>Arizona (AZ)</option>
    <option value="AR" {{ $selectedState == 'AR' ? 'selected' : '' }}>Arkansas (AR)</option>
    <option value="CA" {{ $selectedState == 'CA' ? 'selected' : '' }}>California (CA)</option>
    <option value="CO" {{ $selectedState == 'CO' ? 'selected' : '' }}>Colorado (CO)</option>
    <option value="CT" {{ $selectedState == 'CT' ? 'selected' : '' }}>Connecticut (CT)</option>
    <option value="DE" {{ $selectedState == 'DE' ? 'selected' : '' }}>Delaware (DE)</option>
    <option value="FL" {{ $selectedState == 'FL' ? 'selected' : '' }}>Florida (FL)</option>
    <option value="GA" {{ $selectedState == 'GA' ? 'selected' : '' }}>Georgia (GA)</option>
    <option value="HI" {{ $selectedState == 'HI' ? 'selected' : '' }}>Hawaii (HI)</option>
    <option value="ID" {{ $selectedState == 'ID' ? 'selected' : '' }}>Idaho (ID)</option>
    <option value="IL" {{ $selectedState == 'IL' ? 'selected' : '' }}>Illinois (IL)</option>
    <option value="IN" {{ $selectedState == 'IN' ? 'selected' : '' }}>Indiana (IN)</option>
    <option value="IA" {{ $selectedState == 'IA' ? 'selected' : '' }}>Iowa (IA)</option>
    <option value="KS" {{ $selectedState == 'KS' ? 'selected' : '' }}>Kansas (KS)</option>
    <option value="KY" {{ $selectedState == 'KY' ? 'selected' : '' }}>Kentucky (KY)</option>
    <option value="LA" {{ $selectedState == 'LA' ? 'selected' : '' }}>Louisiana (LA)</option>
    <option value="ME" {{ $selectedState == 'ME' ? 'selected' : '' }}>Maine (ME)</option>
    <option value="MD" {{ $selectedState == 'MD' ? 'selected' : '' }}>Maryland (MD)</option>
    <option value="MA" {{ $selectedState == 'MA' ? 'selected' : '' }}>Massachusetts (MA)</option>
    <option value="MI" {{ $selectedState == 'MI' ? 'selected' : '' }}>Michigan (MI)</option>
    <option value="MN" {{ $selectedState == 'MN' ? 'selected' : '' }}>Minnesota (MN)</option>
    <option value="MS" {{ $selectedState == 'MS' ? 'selected' : '' }}>Mississippi (MS)</option>
    <option value="MO" {{ $selectedState == 'MO' ? 'selected' : '' }}>Missouri (MO)</option>
    <option value="MT" {{ $selectedState == 'MT' ? 'selected' : '' }}>Montana (MT)</option>
    <option value="NE" {{ $selectedState == 'NE' ? 'selected' : '' }}>Nebraska (NE)</option>
    <option value="NV" {{ $selectedState == 'NV' ? 'selected' : '' }}>Nevada (NV)</option>
    <option value="NH" {{ $selectedState == 'NH' ? 'selected' : '' }}>New Hampshire (NH)</option>
    <option value="NJ" {{ $selectedState == 'NJ' ? 'selected' : '' }}>New Jersey (NJ)</option>
    <option value="NM" {{ $selectedState == 'NM' ? 'selected' : '' }}>New Mexico (NM)</option>
    <option value="NY" {{ $selectedState == 'NY' ? 'selected' : '' }}>New York (NY)</option>
    <option value="NC" {{ $selectedState == 'NC' ? 'selected' : '' }}>North Carolina (NC)</option>
    <option value="ND" {{ $selectedState == 'ND' ? 'selected' : '' }}>North Dakota (ND)</option>
    <option value="OH" {{ $selectedState == 'OH' ? 'selected' : '' }}>Ohio (OH)</option>
    <option value="OK" {{ $selectedState == 'OK' ? 'selected' : '' }}>Oklahoma (OK)</option>
    <option value="OR" {{ $selectedState == 'OR' ? 'selected' : '' }}>Oregon (OR)</option>
    <option value="PA" {{ $selectedState == 'PA' ? 'selected' : '' }}>Pennsylvania (PA)</option>
    <option value="RI" {{ $selectedState == 'RI' ? 'selected' : '' }}>Rhode Island (RI)</option>
    <option value="SC" {{ $selectedState == 'SC' ? 'selected' : '' }}>South Carolina (SC)</option>
    <option value="SD" {{ $selectedState == 'SD' ? 'selected' : '' }}>South Dakota (SD)</option>
    <option value="TN" {{ $selectedState == 'TN' ? 'selected' : '' }}>Tennessee (TN)</option>
    <option value="TX" {{ $selectedState == 'TX' ? 'selected' : '' }}>Texas (TX)</option>
    <option value="UT" {{ $selectedState == 'UT' ? 'selected' : '' }}>Utah (UT)</option>
    <option value="VT" {{ $selectedState == 'VT' ? 'selected' : '' }}>Vermont (VT)</option>
    <option value="VA" {{ $selectedState == 'VA' ? 'selected' : '' }}>Virginia (VA)</option>
    <option value="WA" {{ $selectedState == 'WA' ? 'selected' : '' }}>Washington (WA)</option>
    <option value="WV" {{ $selectedState == 'WV' ? 'selected' : '' }}>West Virginia (WV)</option>
    <option value="WI" {{ $selectedState == 'WI' ? 'selected' : '' }}>Wisconsin (WI)</option>
    <option value="WY" {{ $selectedState == 'WY' ? 'selected' : '' }}>Wyoming (WY)</option>

    <!-- Territories -->
    <option value="DC" {{ $selectedState == 'DC' ? 'selected' : '' }}>District of Columbia (DC)</option>
    <option value="AS" {{ $selectedState == 'AS' ? 'selected' : '' }}>American Samoa (AS)</option>
    <option value="GU" {{ $selectedState == 'GU' ? 'selected' : '' }}>Guam (GU)</option>
    <option value="MP" {{ $selectedState == 'MP' ? 'selected' : '' }}>Northern Mariana Islands (MP)</option>
    <option value="PR" {{ $selectedState == 'PR' ? 'selected' : '' }}>Puerto Rico (PR)</option>
    <option value="VI" {{ $selectedState == 'VI' ? 'selected' : '' }}>U.S. Virgin Islands (VI)</option>
</select>

                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label>Zip<sup>*</sup></label>

                                                    <input name="zip" class="form-control" type="text"
                                                        placeholder="Zip" value="{{ auth()->user()->zip }}" />
                                                    @error('zip')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="form-group">
                                                    <h4>Medical Conditions</h4>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label>Existing medical conditions?<sup>*</sup></label>
                                                    <input class="form-control" type="text" placeholder="|"
                                                        value="{{auth()->user()->existing_medical_conditions}}" name="existing_conditions"/>
                                                        @error('existing_conditions')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label>Currently taking medications?<sup>*</sup></label>
                                                    <input class="form-control" type="text" placeholder="|"
                                                        value="{{auth()->user()->currently_taking_medications}}" name="current_medications"/>
                                                         @error('current_medications')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label>Known allergies?<sup>*</sup></label>
                                                    <input class="form-control" type="text" placeholder="|"
                                                        value="{{auth()->user()->known_allergies}}" name="known_allergies"/>
                                                        @error('known_allergies')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label>Any previous surgeries?<sup>*</sup> </label>
                                                    <input class="form-control" type="text" placeholder="|"
                                                        value="{{auth()->user()->previous_surgeries}}" name="previous_surgeries"/>
                                                         @error('previous_surgeries')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-8">
                                                <div class="form-btn-wrap">
                                                    <ul>
                                                        <li>
                                                           <button class="btn discard-btn" type="reset">Discard</button>
                                                        </li>
                                                        <li>
                                                            <button class="btn common-btn2"
                                                                type="submit">Save</button>
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

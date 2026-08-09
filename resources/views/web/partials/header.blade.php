 <header class="header-wrapper">
     <div class="container-fluid">
         <div class="row">

             <div class="col-12">
                 <nav class="navbar navbar-expand-lg navbar-light responsive-menu ">
                     <div class="logo-wrap">
                         <a class="navbar-brand" href="{{ route('index') }}">
                             <img class="img-fluid" src="{{ url('assets/images/logo.png') }}" alt="">
                         </a>
                     </div>

                     <div class="menu-wrap justify-content-center me-auto ms-auto" id="navbarNav">

                         <ul class="main-menu me-auto ms-auto">
                             <li class="{{ request()->routeIs('index') ? 'current' : '' }}">
                                 <a href="{{ route('index') }}"><span>Home </span></a>

                             </li>
                             <li class="{{ request()->routeIs('drugs.info') ? 'current' : '' }} ">
                                 <a href="{{ route('drugs.info') }}"><span>Drug Information </span></a>

                             </li>
                             <li class="{{ request()->routeIs('sponsor') ? 'current' : '' }}">
                                 <a href="{{ route('sponsor') }}">Sponsors</a>
                             </li>
                             <li class="{{ request()->routeIs('askai') ? 'current' : '' }}">
                                 <a href="{{ route('askai') }}">Ask Duke Using AI</a>
                             </li>

                             <li class="{{ request()->routeIs('clinical-trails') ? 'current' : '' }}">
                                 <a href="{{ route('clinical-trails') }}">Sign up for Clinical Trials</a>
                             </li>

                             <li class="{{ request()->routeIs('coupons') ? 'current' : '' }}">
                                 <a href="{{ route('coupons') }}">Coupons</a>
                             </li>

<li class="{{ request()->routeIs('donation') ? 'current' : '' }}">
                                         <a href="{{ route('donation') }}">Donation</a>
                                     </li>

                             <li class="{{ request()->routeIs( 'forum', 'media', 'faq') ? 'current' : '' }} sub-dropdown">
                                 <a href="#">Others</a>
                                 <ul class="sub-menu">

                                     <li class="{{ request()->routeIs('forum') ? 'current' : '' }}"><a href="{{ route('forum') }}"><span> Forum </span></a></li>
                                     <li class="{{ request()->routeIs('media') ? 'current' : '' }}"><a href="{{ route('media') }}"><span>CDC Media</span></a></li>
                                     <li class="{{ request()->routeIs('faq') ? 'current' : '' }}"><a href="{{ route('faq') }}"><span>FAQs</span></a></li>


                                     

                                 </ul>
                             </li>

                         </ul>
                     </div>

                     <div class="my-ac-wrap">
                         <ul>
                             <li>
                                 <div class="head-search-wrap">
                                     <form action="{{ route('drugs.search') }}" method="GET" target="_blank">
                                         <div class="search-box-inner">
                                             <div class="search-btn-wrp">
                                                 <button class="search-btn" type="submit">
                                                     <i class="fa-solid fa-magnifying-glass"></i>
                                                 </button>
                                             </div>
                                             <div class="search-box">
                                                 <input class="form-control" type="search" name="query" placeholder="Search Drugs..." value="{{ request('query') }}">
                                             </div>
                                         </div>
                                     </form>
                                 </div>
                             </li>
                             @auth
                             {{-- <li>
                    <a href="#">{{auth()->user()->name.' '.auth()->user()->last_name}}</a>
                             </li> --}}
                             <li>
                                 <a href="{{ route('dashboard') }}"> Dashboard</a>
                             </li>
                             <li> <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                     Log out
                                 </a>
                                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                     @csrf
                                 </form>
                             </li>
                             @endauth
                             @guest
                             <li>
                                 <a href="{{ route('login') }}">Login</a>
                             </li>
                             <li>
                                 <a href="{{ route('registration') }}">Register</a>
                             </li>
                             @endguest

                         </ul>
                     </div>

                     <a href="#" class="toggle-menu" data-toggle-class="active" data-toggle-target=".main-menu, this"><span><i class="fa fa-bars" aria-hidden="true"></i></span></a>

                 </nav>
             </div>

         </div>
     </div>
 </header>

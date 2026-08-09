 <footer class="footer-wrapper">
     <div class="footer-main-wrapper">
         <div class="container">
             <div class="row">
                 <div class="col-12 col-md-6 col-lg-3 mb-4">
                     <div class="footer-inner-wrap">
                         <div class="footer-logo mb-4">
                             <a href="index.html">
                                 <img class="img-fluid" src="{{ url('assets/images/logo.png') }}" alt="">
                             </a>
                         </div>
                         <div class="footer-search-wrap">
                             <form action="{{ route('drugs.search') }}" method="GET" target="_blank">
                                 <div class="search-box-inner">
                                     <div class="search-btn-wrp">
                                         <button class="search-btn" type="submit">
                                             <i class="fa-solid fa-magnifying-glass"></i>
                                         </button>
                                     </div>
                                     <div class="search-box">
                                         <input class="form-control" type="search" name="query"
                                             placeholder="Search Drugs..." value="{{ request('query') }}">
                                     </div>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>
                 <div class="col-12 col-md-6 col-lg-4 mb-4">
                     <div class="footer-inner-wrap">
                         <h3>Quick Links </h3>
                         <div class="footer-menu">
                             <ul>
                                 <li>
                                     <a href="{{ url('/') }}">Home</a>
                                 </li>
                                 <li>
                                     <a href="{{ route('media') }}">CDC Media</a>
                                 </li>
                                 <li>
                                     <a href="{{ route('drugs.info') }}">Drug Information</a>
                                 </li>
                                 <li>
                                     <a href="{{ route('faq') }}">FAQ</a>
                                 </li>
                                 <li>
                                     <a href="{{ route('forum') }}">Forum</a>
                                 </li>
                                
                                 {{-- <li>
                                     <a href="{{route('privacy')}}">Privacy Policy </a>
                                 </li>
                                 <li>
                                     <a href="{{route('terms')}}">Terms of Use </a>
                                 </li> --}}
                                  <li>
                                         <a href="{{ route('sponsor') }}">Sponsors</a>
                                     </li>
                                     <li>
                                         <a href="{{route('askai')}}">Ask Duke Using AI</a>
                                     </li>

                                    
                                     <li>
                                         <a href="{{ route('coupons') }}">Coupons</a>
                                     </li>
                                     <li>
                                         <a href="{{ route('donation') }}">Donation</a>
                                     </li>
                                      <li>
                                         <a href="{{ route('clinical-trails') }}">Sign up for Clinical Trials</a>
                                     </li>
                             </ul>
                         </div>
                     </div>
                 </div>
                 <div class="col-12 col-md-6 col-lg-3 mb-4">
                     <div class="footer-inner-wrap">
                         <h3>Contact Info</h3>
                         <div class="contact-det-list">
                             <span class="icon">
                                 <i class="las la-map-marker-alt"></i>
                             </span>
                             <div class="content">
                                 <p>{!! \App\Utils\Helper::getSetting('address') !!}</p>
                             </div>
                         </div>
                         <div class="contact-det-list">
                             <span class="icon">
                                 <i class="las la-envelope"></i>
                             </span>
                             <div class="content">
                                 <p><a
                                         href="mailto:{{ \App\Utils\Helper::getSetting('email') }}">{{ \App\Utils\Helper::getSetting('email') }}</a>
                                 </p>
                             </div>
                         </div>
                         <div class="contact-det-list">
                             <span class="icon">
                                 <i class="las la-phone"></i>
                             </span>
                             <div class="content">
                                 <p><a
                                         href="tel:{{ \App\Utils\Helper::getSetting('contact') }}">{{ \App\Utils\Helper::getSetting('contact') }}</a>
                                 </p>
                             </div>
                         </div>

                     </div>
                 </div>
                 <div class="col-12 col-md-6 col-lg-2 mb-4">
                     <div class="footer-inner-wrap">
                         <h3>Follow Us</h3>
                         <div class="footer-social">
                             <ul>
                                 <li>
                                     <a href="{{ \App\Utils\Helper::getSetting('insta.link') }}"><i
                                             class="fa-brands fa-instagram"></i></a>
                                 </li>
                                 <li>
                                     <a href="{{ \App\Utils\Helper::getSetting('tw.link') }}"><i
                                             class="fa-brands fa-x-twitter"></i></a>
                                 </li>
                                 <li>
                                     <a href="{{ \App\Utils\Helper::getSetting('in.link') }}"><i
                                             class="fa-brands fa-linkedin-in"></i></a>
                                 </li>
                             </ul>
                         </div>

                     </div>
                 </div>


             </div>
             <div class="row">
                 <div class="col-12 mb-3">
                     <div class="line">
                         <hr>
                     </div>
                 </div>
                 <div class="col-12 col-md-6 order-md-2">
                     <div class="footer-trams-menu">
                         <ul>
                             <li>
                                 <a href="{{route('terms')}}">Terms of Use</a>
                             </li>
                             <li>
                                 <a href="{{route('privacy')}}">Privacy Policy</a>
                             </li>
                         </ul>
                     </div>
                 </div>
                 <div class="col-12 col-md-6 order-md-1">
                     <div class="footer-copyright">
                         <p>Copyright ©{{date('Y')}} Mr. Health, Inc. All Rights Reserved. <br>We pray to God for your good health and well-being. </p>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </footer>

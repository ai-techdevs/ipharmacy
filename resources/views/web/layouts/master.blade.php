<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ipharmacy</title>
    <!-- Bootstrap -->
    <link rel="shortcut icon" href="{{ url('assets/images/favicon.jpg')}}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- fontawesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" media="all">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="{{ url('assets/css/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/aos.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/menu.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/style.css') }}?v=1.0.6" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/responsive.css') }}" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @stack('style')
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-MXG2FEG617"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-MXG2FEG617');
</script>
</head>

<body>
    @include('web/partials/header')



    @yield('content')
    @if (request()->routeIs('drug.detail') && !request()->is('drugs-detail/*/ask-doctor'))
    <div class="floating-btn-wrap">
        <button class="floating-btn-tigger">
            <i class="fa-solid fa-plus"></i>
        </button>
        <div class="floating-content">
            <ul>
                <li>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#ShareSocialModal">
                        <div class="name">Share With a Friend</div>
                        <div class="icon">
                            <img class="img-fluid" src="{{ asset('assets/images/share-icon.svg') }}" alt="">
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#ShareVideoModal">
                        <div class="name">Watch a Video</div>
                        <div class="icon">
                            <img class="img-fluid" src="{{ asset('assets/images/video-icon.svg') }}" alt="">
                        </div>
                    </a>
                </li>
                <!--@if (!empty($medicine->pdf_path))-->
                <!--<li>-->
                <!--    <a target="_blank" href="{{ url('storage/' . $medicine->pdf_path) }}" data-medicine-id="{{ $medicine->id }}" class="pdf-download">-->
                <!--        <div class="name">Download PDF File</div>-->
                <!--        <div class="icon">-->
                <!--            <img class="img-fluid" src="{{ asset('assets/images/file-icon.svg') }}" alt="">-->
                <!--        </div>-->
                <!--    </a>-->
                <!--</li>-->
                <!--@endif-->
                
                <li>
    @if (!empty($medicine->pdf_path))
        <a 
           href="javascript:void(0);"
           data-medicine-id="{{ $medicine->id }}"
           class="pdf-download">
           <div class="name">Download PDF File</div>
    @else
        <a href="javascript:void(0)"
           data-bs-toggle="modal"
           data-bs-target="#NoPdfModal">
           <div class="name">Download PDF File</div>
            <div class="icon">
                <img class="img-fluid" src="{{ asset('assets/images/file-icon.svg') }}" alt="">
            </div>
    @endif
        
        @if (!empty($medicine->pdf_path))
        <div class="icon">
        <i class="fa-solid fa-file-pdf fa-1x text-danger mb-0" onclick="window.open('{{ url('storage/' . $medicine->pdf_path) }}','_blank')"></i>
        </div>
        @endif
        @if (!empty($medicine->pdf_path2))
        <div class="icon">
        <i class="fa-solid fa-file-pdf fa-1x text-danger mb-0" onclick="window.open('{{ url('storage/' . $medicine->pdf_path2) }}','_blank')"></i>
        </div>
        @endif
        @if (!empty($medicine->pdf_path3))
        <div class="icon">
        <i class="fa-solid fa-file-pdf fa-1x text-danger mb-0" onclick="window.open('{{ url('storage/' . $medicine->pdf_path3) }}','_blank')"></i>
        </div>
        @endif
    </a>
</li>

                <li>
                    <a href="{{ route('ask.doctor', $medicine->slug) }}">
                        <div class="name">Ask My Doctor If this Drug is Right For Me</div>
                        <div class="icon">
                            <img class="img-fluid" src="{{ asset('assets/images/info-question-icon.svg') }}" alt="">
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @endif

    @include('web/partials/footer')

    {{-- @if (request()->is('drug-information/*')) --}}
    @if (request()->routeIs('drug.detail'))
    <!-- share social media -->

    @php

    $rawUrl = request()->fullUrl();
    $encodedUrl = urlencode($rawUrl);
    $title = 'Check out this Drug Information : ' . $medicine->name;
    $encodedTitle = urlencode($title);
    @endphp
    <div class="modal fade share-social-modal-wrap" id="ShareSocialModal" tabindex="-1" aria-labelledby="ShareSocialLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                <div class="modal-body">
                    <div class="title">
                        <h3>Share</h3>
                    </div>
                    <div class="social-media-wrap">
                        <ul>
                            <li>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" target="_blank">
                                    <img class="img-fluid" src="{{ asset('assets/images/social-icon-facebook.png') }}" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="mailto:?subject={{ $title }}&body={{ $title }} {{ $rawUrl }}">
                                    <img class="img-fluid" src="{{ asset('assets/images/social-icon-email.png') }}" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/intent/tweet?url={{ $encodedUrl }}&text={{ $encodedTitle }}" target="_blank">
                                    <img class="img-fluid" src="{{ asset('assets/images/social-icon-twitter.png') }}" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $encodedUrl }}" target="_blank">
                                    <img class="img-fluid" src="{{ asset('assets/images/social-icon-linkedin.png') }}" alt="">
                                </a>
                            </li>
                            <li>
                                <a href="https://wa.me/?text={{ $title }} {{ $rawUrl }}" target="_blank">
                                    <img class="img-fluid" src="{{ asset('assets/images/social-icon-whatsapp.png') }}" alt="">
                                </a>
                            </li>
                            <li>
    <a href="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode($rawUrl) }}"
       target="_blank">
        <img class="img-fluid"
             src="{{ asset('assets/images/social-icon-wechat.png') }}"
             alt="WeChat">
    </a>
</li>
                            {{-- <li>
                  <a href="#">
                    <img class="img-fluid" src="{{asset('assets/images/social-icon-wechat.png') }}" alt="">
                            </a>
                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ask Doctor -->
    <div class="modal fade send-email-modal-wrap" id="SendMailModal" tabindex="-1" aria-labelledby="SendMailLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                <div class="modal-body">
                    <div class="title">
                        <h3>Send Email </h3>
                    </div>
                    <form method="POST" id="doctorForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label>Dr Name</label>
                            <input class="form-control" type="text" name="doctor_name" placeholder="Name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Email To</label>
                            <input class="form-control" type="email" name="doctor_email" placeholder="Enter Your Dr Email" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="submit" class="common-btn2" value="Send" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Video Modal-->
    <div class="modal fade" id="ShareVideoModal" tabindex="-1" aria-labelledby="ShareVideoLabel" aria-hidden="true" data-medicine-id="{{ $medicine->id }}">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
               <button type="button"
            class="btn-close position-absolute top-0 end-0 m-3"
            data-bs-dismiss="modal"
            aria-label="Close"
            style="z-index: 9999;">
    </button>
                <div class="modal-body p-0">
                    <!--<div class="ratio ratio-16x9">-->

                    <!--    {!! $medicine->video_path !!}-->
                    <!--    {{-- <iframe title="YouTube video player" src="{{ $medicine->video_path }}" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen="allowfullscreen" referrerpolicy="strict-origin-when-cross-origin"></iframe> --}}-->
                    <!--</div>-->
                     @if(isset($medicine->video_path) && trim($medicine->video_path) != '')
        <div class="ratio ratio-16x9">
            {!! $medicine->video_path !!}
        </div>
    @else
        <img class="img-fluid w-100"
             src="{{ url('assets/images/No video.jpg') }}"
             alt="No Video Available">
    @endif
                </div>
            </div>
        </div>
    </div>
    
    
<div class="modal fade" id="NoPdfModal" tabindex="-1" aria-labelledby="NoPdfModalLabel" aria-hidden="true">
    
      <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <!--<button type="button" class="close btn btn-light position-absolute end-0 m-2" data-bs-dismiss="modal" aria-label="Close">-->
                <!--    <i class="fa-solid fa-xmark"></i>-->
                <!--</button>-->
                   <button type="button"
            class="btn-close position-absolute top-0 end-0 m-3"
            data-bs-dismiss="modal"
            aria-label="Close"
            style="z-index: 9999;">
    </button>
                   <div class="modal-body p-4">
                <i class="fa-solid fa-file-circle-xmark fa-3x text-danger mb-3"></i>
                <h5>No PDF Available</h5>
                <p class="text-muted mb-0">
                    Sorry, the PDF file for this medicine is not available at the moment.
                </p>
            </div>
            </div>
        </div>

</div>
    @endif

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ url('assets/js/slick.min.js') }}"></script>
    <script src="{{ url('assets/js/aos.js') }}"></script>
    <script src="{{ url('assets/js/menu.js') }}"></script>
    <script src="{{ url('assets/js/external.js') }}?v=1.0.1"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha_v3.site_key') }}"></script>

<script>
grecaptcha.ready(function () {
    grecaptcha.execute('{{ config('services.recaptcha_v3.site_key') }}', {
        action: 'page_view'
    }).then(function (token) {
        window.recaptchaV3Token = token;
    });
});
</script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let videoModal = document.getElementById("ShareVideoModal");

            videoModal.addEventListener("shown.bs.modal", function() {
                let medicineId = videoModal.getAttribute("data-medicine-id");

                fetch("{{ route('medicine.video.watch', ':id') }}".replace(':id', medicineId), {
                    method: "POST"
                    , headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        , "Content-Type": "application/json"
                    , }
                , });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".pdf-download").forEach(link => {
                link.addEventListener("click", function() {
                    let medicineId = this.getAttribute("data-medicine-id");

                    fetch("{{ route('medicine.pdf.download', ':id') }}".replace(':id', medicineId), {
                        method: "POST"
                        , headers: {
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]').content
                            , "Content-Type": "application/json"
                        , }
                    , });
                });
            });
        });
$(window).scroll(function() {
    var height = $(window).scrollTop();
    if (height > 200) {
        $('#back2Top').fadeIn();
    } else {
        $('#back2Top').fadeOut();
    }
  });
  $(document).ready(function() {
    $("#back2Top").click(function(event) {
        event.preventDefault();
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });
 
  });
    </script>

    @stack('scripts')
      <a class="top" id="back2Top" href="#"><img src="{{ asset('assets/images/backtoTop0.png')}}" alt=""></a>
</body>

</html>

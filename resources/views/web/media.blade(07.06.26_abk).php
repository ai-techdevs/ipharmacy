@extends('web/layouts/master')

@section('content')
     <section class="inner-banner-wrapper">
      <div class="inner-banner-wrap">
        <div class="container">
          <div class="row">
            <div class="col-12 text-center">
              <nav class="banner-breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">CDC Media</li>
                </ol>
              </nav>
              <h1>CDC Media</h1>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="cdc-media-wrapper ">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-7 mb-4">
                    <div class="common-title">
                        <p>Welcome to the iPharmacy CDC Media Center, your trusted source for the latest health news, disease awareness updates, pharmacy insights, wellness education, and public health information. Our mission is to provide reliable, easy-to-understand healthcare content that helps individuals, families, caregivers, and healthcare professionals stay informed about emerging health concerns and preventive care practices. <br/>

                        Through our CDC Media section, we share important updates on infectious diseases, public health advisories, medication safety, vaccination awareness, chronic disease management, nutrition, and wellness topics that impact communities worldwide. Public health agencies regularly publish information on disease outbreaks, prevention strategies, and healthcare recommendations to help individuals make informed health decisions.</p>
                    </div>
                </div>
                <div class="col-12 col-md-5 mb-4">
                    <div class="right-img">
                        <img class="img-fluid w-75 float-end" src="{{url('assets/images/Digital-Photo-for-the-CDC-main-page.png')}}">
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-2 mb-md-4">
                    <div class="common-title">
                        <h3>Our CDC Media</h3>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <div class="common-title">
                        <!-- <p>Aenean posuere justo vel finibus vulputate. Donec pellentesque rhoncus neque sed bibendum.
                            Curabitur efficitur mauris</p> -->
                    </div>
                </div>

                @if (count($cdcs) > 0)
                    @foreach ($cdcs as $cdc)
                        <div class="col-12 col-md-4 mb-4">
                            <div class="cdc-media-list">
                                <div class="img-box">
                                    <img class="img-fluid"
                                        src="{{ !empty($cdc->image) && file_exists(public_path('storage/' . $cdc->image)) ? asset('storage/' . $cdc->image) : url('assets/images/cdc-media-img1.jpg') }}"
                                        alt="">
                                    <div class="cdc-btn-wrap">
                                        <a href="{{route('media-detail',$cdc->slug)}}" class="cdc-btn"><i class="fa-solid fa-arrow-right-long"></i></a>
                                    </div>
                                </div>
                                <div class="cdc-media-content">
                                    <h5>{{ $cdc->author }} {{ \Carbon\Carbon::parse($cdc->created_at)->format('jS F Y') }}
                                    </h5>
                                    <h4><a href="{{route('media-detail',$cdc->slug)}}">{{ $cdc->title }}</a></h4>
                                    <p>{!! Str::limit($cdc->description, 100) !!} </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 col-md-12 mb-12 text-center">


                        <h5>Nothing found!</h5>

                    </div>
                @endif

                {{-- <div class="col-12 col-md-4 mb-4">
                    <div class="cdc-media-list">
                        <div class="img-box">
                            <img class="img-fluid" src="{{ url('assets/images/cdc-media-img1.jpg') }}" alt="">
                            <div class="cdc-btn-wrap">
                                <a href="cdc-media-details.html" class="cdc-btn"><i
                                        class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                        <div class="cdc-media-content">
                            <h5>Jinia Anderson 22th July 2024</h5>
                            <h4><a href="cdc-media-details.html">Empowering Health Through ToOur Knowledge</a></h4>
                            <p>Nulla vulputate ligula eu sagittis vulputate. Integer lac inia molestie mattis. Aliquam
                                ultricies felis </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <div class="cdc-media-list">
                        <div class="img-box">
                            <img class="img-fluid" src="{{ url('assets/images/cdc-media-img2.jpg') }}" alt="">
                            <div class="cdc-btn-wrap">
                                <a href="cdc-media-details.html" class="cdc-btn"><i
                                        class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                        <div class="cdc-media-content">
                            <h5>Jinia Anderson 22th July 2024</h5>
                            <h4><a href="cdc-media-details.html">Empowering Health Through ToOur Knowledge</a></h4>
                            <p>Nulla vulputate ligula eu sagittis vulputate. Integer lac inia molestie mattis. Aliquam
                                ultricies felis </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <div class="cdc-media-list">
                        <div class="img-box">
                            <img class="img-fluid" src="{{ url('assets/images/cdc-media-img3.jpg') }}" alt="">
                            <div class="cdc-btn-wrap">
                                <a href="cdc-media-details.html" class="cdc-btn"><i
                                        class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                        <div class="cdc-media-content">
                            <h5>Jinia Anderson 22th July 2024</h5>
                            <h4><a href="cdc-media-details.html">Empowering Health Through ToOur Knowledge</a></h4>
                            <p>Nulla vulputate ligula eu sagittis vulputate. Integer lac inia molestie mattis. Aliquam
                                ultricies felis </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <div class="cdc-media-list">
                        <div class="img-box">
                            <img class="img-fluid" src="{{ url('assets/images/cdc-media-img4.jpg') }}" alt="">
                            <div class="cdc-btn-wrap">
                                <a href="cdc-media-details.html" class="cdc-btn"><i
                                        class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                        <div class="cdc-media-content">
                            <h5>Jinia Anderson 22th July 2024</h5>
                            <h4><a href="cdc-media-details.html">Empowering Health Through ToOur Knowledge</a></h4>
                            <p>Nulla vulputate ligula eu sagittis vulputate. Integer lac inia molestie mattis. Aliquam
                                ultricies felis </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <div class="cdc-media-list">
                        <div class="img-box">
                            <img class="img-fluid" src="{{ url('assets/images/cdc-media-img5.jpg') }}" alt="">
                            <div class="cdc-btn-wrap">
                                <a href="cdc-media-details.html" class="cdc-btn"><i
                                        class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                        <div class="cdc-media-content">
                            <h5>Jinia Anderson 22th July 2024</h5>
                            <h4><a href="cdc-media-details.html">Empowering Health Through ToOur Knowledge</a></h4>
                            <p>Nulla vulputate ligula eu sagittis vulputate. Integer lac inia molestie mattis. Aliquam
                                ultricies felis </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <div class="cdc-media-list">
                        <div class="img-box">
                            <img class="img-fluid" src="{{ url('assets/images/cdc-media-img6.jpg') }}" alt="">
                            <div class="cdc-btn-wrap">
                                <a href="cdc-media-details.html" class="cdc-btn"><i
                                        class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                        <div class="cdc-media-content">
                            <h5>Jinia Anderson 22th July 2024</h5>
                            <h4><a href="cdc-media-details.html">Empowering Health Through ToOur Knowledge</a></h4>
                            <p>Nulla vulputate ligula eu sagittis vulputate. Integer lac inia molestie mattis. Aliquam
                                ultricies felis </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <div class="cdc-media-list">
                        <div class="img-box">
                            <img class="img-fluid" src="{{ url('assets/images/cdc-media-img7.jpg') }}" alt="">
                            <div class="cdc-btn-wrap">
                                <a href="cdc-media-details.html" class="cdc-btn"><i
                                        class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                        <div class="cdc-media-content">
                            <h5>Jinia Anderson 22th July 2024</h5>
                            <h4><a href="cdc-media-details.html">Empowering Health Through ToOur Knowledge</a></h4>
                            <p>Nulla vulputate ligula eu sagittis vulputate. Integer lac inia molestie mattis. Aliquam
                                ultricies felis </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <div class="cdc-media-list">
                        <div class="img-box">
                            <img class="img-fluid" src="{{ url('assets/images/cdc-media-img8.jpg') }}" alt="">
                            <div class="cdc-btn-wrap">
                                <a href="cdc-media-details.html" class="cdc-btn"><i
                                        class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                        <div class="cdc-media-content">
                            <h5>Jinia Anderson 22th July 2024</h5>
                            <h4><a href="cdc-media-details.html">Empowering Health Through ToOur Knowledge</a></h4>
                            <p>Nulla vulputate ligula eu sagittis vulputate. Integer lac inia molestie mattis. Aliquam
                                ultricies felis </p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <div class="cdc-media-list">
                        <div class="img-box">
                            <img class="img-fluid" src="{{ url('assets/images/cdc-media-img9.jpg') }}" alt="">
                            <div class="cdc-btn-wrap">
                                <a href="cdc-media-details.html" class="cdc-btn"><i
                                        class="fa-solid fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                        <div class="cdc-media-content">
                            <h5>Jinia Anderson 22th July 2024</h5>
                            <h4><a href="cdc-media-details.html">Empowering Health Through ToOur Knowledge</a></h4>
                            <p>Nulla vulputate ligula eu sagittis vulputate. Integer lac inia molestie mattis. Aliquam
                                ultricies felis </p>
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
    </section>
@endsection

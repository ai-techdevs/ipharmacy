@extends('web/layouts/master')

@section('content')
<section class="banner-wrapper">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-md-8 offset-md-2 text-center">
            <div class="banner-content">
              <!--{!! $home->section_title ?? "" !!}-->
              {!! \App\Utils\Helper::getSetting('home') !!}
              <p>{{ $home->secion_text ?? ""}}</p>
              {{-- <a href="" class="btn common-btn1">Shop Now <span><i class="fa-solid fa-arrow-right"></i></span></a> --}}
            </div>
          </div>
        </div>
      </div>
      <div class="bnr-img1">
        <img class="img-fluid" src="{{url('assets/images/banner-img1.png')}}" alt="">
      </div>
      <div class="bnr-img2">
        <img class="img-fluid" src="{{url('assets/images/banner-img2.png')}}" alt="">
      </div>
      <div class="bnr-img3">
        <img class="img-fluid" src="{{url('assets/images/banner-img3.png')}}" alt="">
      </div>
      <div class="bnr-img4">
        <img class="img-fluid" src="{{url('assets/images/banner-img4.png')}}" alt="">
      </div>
    </section>

    @if(!empty($banners))
    <section class="partners-about-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-12 mb-4">
            <div class="title">
              <h3>Proud To Work With Incredible Partners</h3>
            </div>
          </div>
          <div class="col-12 mb-5">
            <div class="brands-slider" id="brands-slider">
                @foreach ($banners as $banner)
                    <div class="brands-sld-items">
                        <div class="brands-logo">
                        <img class="img-fluid" src="{{asset('storage/'.$banner->path)}}" alt="">
                        </div>
                    </div>
                @endforeach
            </div>
          </div>
        </div>

        <div class="row align-items-center">
          <div class="col-12 col-md-6">
            <div class="about-left-content">
              <h3>
                  <!--{{ $forum->section_title ?? "" }}-->
                    {!! \App\Utils\Helper::getSetting('home_section_header_1') !!}
                  </h3>
              <p> 
              <!--{{ $forum->section_text ?? "" }}-->
               {!! \App\Utils\Helper::getSetting('home_section_desc_1') !!}
              </p>
              <a href="{{ route('forum') }}" class="btn common-btn1">Show More<span><i class="fa-solid fa-arrow-right"></i></span></a>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="about-right-img">
              <img class="img-fluid" src="{{url('assets/images/about-right-img.png')}}" alt="">
              <!-- <div class="about-img2">
                <img class="img-fluid" src="{{url('assets/images/about-right-img2.png')}}" alt="">
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </section>
    @endif

    <section class="our-cdc-media-wrapper">
      <div class="our-cdc-media-inner-wrap">
        <div class="container">
          <div class="row">
            <div class="col-12 mb-4 text-center">
              <div class="common-title">
                <h3>
                    <!--{{ $cdc->section_title ?? "" }}-->
                    {!! \App\Utils\Helper::getSetting('home_cdc_header') !!}
                    </h3>
                <p>
                    <!--{{ $cdc->section_text ?? "" }}-->
                    {!! \App\Utils\Helper::getSetting('home_cdc_desc') !!}
                    </p>
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
                                <p>{!! Str::limit(strip_tags($cdc->description), 100) !!} </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="col-12 text-center">
              <a href="{{ route('media') }}" class="btn common-btn1">Show More <span><i class="fa-solid fa-arrow-right"></i></span></a>
            </div>

          </div>
        </div>
      </div>
    </section>

    <section class="faq-section-wrapper">
      <div class="container">
        <div class="row">
          <div class="col-12 col-md-6 mb-4 mb-md-0">
            <div class="common-title">
              <h3>{{ $faqSection->section_title }}</h3>
              <p>{{ $faqSection->section_text }}</p>
              <a href="{{ route('faq') }}" class="btn common-btn1">Show More <span><i class="fa-solid fa-arrow-right"></i></span></a>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="faq-wrap">
              <div class="accordion" id="FAQaccordion">
                @foreach($faqs as $key => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ ($key + 1) }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ ($key + 1) }}" aria-expanded="true" aria-controls="collapse{{ ($key + 1) }}">
                            {{$faq->question}}
                        </button>
                        </h2>
                        <div id="collapse{{ ($key + 1) }}" class="accordion-collapse collapse" aria-labelledby="heading{{ ($key + 1) }}" data-bs-parent="#FAQaccordion">
                        <div class="accordion-body">
                            <p>{!!$faq->answer  !!}</p>
                        </div>
                        </div>
                    </div>

                @endforeach
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>

@endsection

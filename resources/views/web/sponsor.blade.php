@extends('web/layouts/master')

@section('content')
<section class="inner-banner-wrapper">
    <div class="inner-banner-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <nav class="banner-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sponsors</li>
                        </ol>
                    </nav>
                    <h1>Our Sponsors</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="sponsors-wrapper common-gap">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <div class="common-title">
                    <h3>Our Sponsors</h3>
                </div>
            </div>

            @if (!empty($sponsors))
            @foreach ($sponsors as $item)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
                <div class="sponsors-logo-list">
                    <img class="img-fluid" src="{{url('storage/'.$item->path)}}" alt="">
                </div>
            </div>
            @endforeach
            @endif


            {{-- <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
            <div class="sponsors-logo-list">
              <img class="img-fluid" src="{{url('assets/images/sponsors-logo2.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo3.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo4.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo5.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo6.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo7.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo8.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo9.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo10.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo11.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo12.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo1.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo2.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo3.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo4.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo5.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo6.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo7.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo8.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo9.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo10.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo11.png')}}" alt="">
        </div>
    </div>
    <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4">
        <div class="sponsors-logo-list">
            <img class="img-fluid" src="{{url('assets/images/sponsors-logo12.png')}}" alt="">
        </div>
    </div> --}}

    </div>
    </div>
</section>
@endsection

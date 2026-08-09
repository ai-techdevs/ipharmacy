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
                            <li class="breadcrumb-item active" aria-current="page">Coupons</li>
                        </ol>
                    </nav>
                    <h1>Coupons</h1>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- <section class="coupons-wrapper common-gap">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="coupons-inner-wrap">
              <div class="row align-items-center">
                <div class="col-12 col-lg-7 mb-3 mb-lg-0">
                  <div class="coupons-left-content">
                    <div class="offer-text">
                      <div class="off">30% Off</div>
                    </div>
                    <h3>Your Prescription for Savings</h3>
                    <p>Aenean posuere justo vel finibus vulputate. Donec pellentesque rhoncus neque sed bibendum Curabitur efficitur mauris </p>
                    <a href="#" class="coupons-btn">Grab Now</a>
                  </div>
                </div>
                <div class="col-12 col-lg-5">
                  <div class="coupons-right-img">
                    <img class="img-fluid" src="{{url('assets/images/coupons-right-img.png')}}" alt="">
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section> --}}

<section class="coupons-wrapper ">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-7 mb-4">
          <div class="common-title">
              <p>At iPharmacy, we believe that quality healthcare should be affordable for everyone. Our Coupons & Promotions page is designed to help you save on health, wellness, pharmacy, and personal care products while enjoying a seamless shopping experience. <br/>
              Whether you're purchasing vitamins, supplements, wellness essentials, healthcare products, or everyday pharmacy items, our exclusive coupons and promotional offers help you get the best value on every order. Many online pharmacy customers actively look for promo codes, discounts, and special offers before making a purchase, making coupons an effective way to maximize savings.</p>
          </div>
      </div>
      <div class="col-12 col-md-5 mb-4">
          <div class="right-img">
              <img class="img-fluid w-75 float-end" src="{{url('assets/images/Digital-Photo-for-the-Coupons-main-page.png')}}" >
          </div>
      </div>

        <!-- @if (isset($cdcs))
        <div class="col-12 col-md-12 mb-2 mb-md-4">
            <div class="common-title">
                
                <h3>Coupons Beginning With The Letter {{ $letter }} </h3>
                
            </div>
        </div>
          @endif -->
        @if (isset($coupons_list_pre) && count($coupons_list_pre) == 0)
        @for ($i = 97; $i <= 122; $i++)

            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="drug-name-list">
                <h4>Coupons Beginning With </h4>
                <h5>The Letter {{ strtoupper(chr($i)) }} </h5>
                <a class="arrow-btn" href="{{ route('coupons-letter', chr($i))}}"><i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        @endfor
        @endif

      @if (!isset($coupons_list_pre))
      @forelse($coupons as $coupon)
        <div class="col-12 mb-4">
          <div class="coupons-inner-wrap">
            <div class="row align-items-center">
                
<!--              <div class="col-12 col-lg-7 mb-3 mb-lg-0">-->
<!--                <div class="coupons-left-content">-->
<!--                  <div class="offer-text">-->
<!--                    <div class="off">{{ $coupon->discount }}</div>-->
<!--                  </div>-->
<!--                  <h3>{{ $coupon->title }}</h3>-->
<!--                  <p>{{ $coupon->description }}</p>-->
<!--                  <a href="{{ route('coupon.pdf', $coupon->id) }}" class="coupons-btn" target="_blank">-->
<!--    {{ $coupon->button_text ?? 'Grab Now' }}-->
<!--</a>-->
<!--                </div>-->
<!--              </div>-->
<!--              <div class="col-12 col-lg-5">-->
<!--                <div class="coupons-right-img">-->
<!--                  <img class="img-fluid" -->
<!--                       src="{{ $coupon->image ? asset('storage/' . $coupon->image) : url('assets/images/coupons-right-img.png') }}" -->
<!--                       alt="{{ $coupon->title }}">-->
<!--                </div>-->
<!--              </div>-->
@if(!empty($coupon->image) && !empty($coupon->image2))

    <div class="col-12 col-lg-6 mb-3 mb-lg-0">
        <div class="coupons-left-content">
            <div class="offer-text">
                <div class="off">{{ $coupon->discount }}</div>
            </div>
            <h3>{{ $coupon->title }}</h3>
            <p>{{ $coupon->description }}</p>
            <a href="{{ route('coupon.pdf', $coupon->id) }}" class="coupons-btn" target="_blank">
                {{ $coupon->button_text ?? 'Grab Now' }}
            </a>
        </div>
    </div>

    <div class="col-12 col-lg-3">
        <div class="coupons-right-img">
            <img class="img-fluid"
                 src="{{ asset('storage/' . $coupon->image) }}"
                 alt="{{ $coupon->title }}">
        </div>
    </div>

    <div class="col-12 col-lg-3">
        <div class="coupons-right-img">
            <img class="img-fluid"
                 src="{{ asset('storage/' . $coupon->image2) }}"
                 alt="{{ $coupon->title }}">
        </div>
    </div>

@else

    <div class="col-12 col-lg-7 mb-3 mb-lg-0">
        <div class="coupons-left-content">
            <div class="offer-text">
                <div class="off">{{ $coupon->discount }}</div>
            </div>
            <h3>{{ $coupon->title }}</h3>
            <p>{{ $coupon->description }}</p>
            <a href="{{ route('coupon.pdf', $coupon->id) }}" class="coupons-btn" target="_blank">
                {{ $coupon->button_text ?? 'Grab Now' }}
            </a>
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="coupons-right-img">
            <img class="img-fluid"
                 src="{{ $coupon->image
                        ? asset('storage/' . $coupon->image)
                        : (!empty($coupon->image2)
                            ? asset('storage/' . $coupon->image2)
                            : url('assets/images/coupons-right-img.png')) }}"
                 alt="{{ $coupon->title }}">
        </div>
    </div>

@endif

            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <p class="text-center">No coupons available.</p>
        </div>
      @endforelse
      <div class="col-12 mt-4">
          {{ $coupons->links('pagination::bootstrap-5') }}
      </div>
      @endif
      
    </div>
  </div>
</section>


@endsection

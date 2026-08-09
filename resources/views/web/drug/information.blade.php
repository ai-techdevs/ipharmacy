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
                  <li class="breadcrumb-item active" aria-current="page">Drug Information</li>
                </ol>
              </nav>
              <h1>Drug Information</h1>
            </div>
          </div>
        </div>
      </div>
</section>

 <section class="drug-information-wrapper">
      <div class="container">
        <div class="row g-3">
          <div class="col-12 mb-4 text-center">
            <div class="common-title">
              <h3>Drugs Name A-Z </h3>
            </div>
          </div>

          @for ($i = 97; $i <= 122; $i++)

        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
          <div class="drug-name-list">
              <h4>Drugs Beginning With </h4>
              <h5>The Letter {{ strtoupper(chr($i)) }} </h5>
              <a class="arrow-btn" href="{{ route('drugs.index', chr($i))}}"><i class="fa-solid fa-arrow-right"></i></a>
            </div>
          </div>
         @endfor


        </div>
      </div>
    </section>

@endsection

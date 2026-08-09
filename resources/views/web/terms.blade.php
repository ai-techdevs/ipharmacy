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
                  <li class="breadcrumb-item active" aria-current="page">{{$page->page_name}}</li>
                </ol>
              </nav>
              <h1>{{$page->page_name}}</h1>
            </div>
          </div>
        </div>
      </div>
    </section>
<section class="faq-wrapper common-gap">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center mb-4">
            <div class="common-title">
              {{-- <h3>{{$page->page_name}}</h3> --}}
              {{-- <p>Aenean posuere justo vel finibus vulputate. Donec pellentesque rhoncus neque sed bibendum. Curabitur efficitur pellentesque rhoncus neque  mauris vel nibh faucibus dictum. Proin finibus pellentesqu Aenean posuere justo</p> --}}
            </div>
          </div>
          <div class="col-12">

            <div class="faq-wrap">
            
               
              {!!$page->description!!}

             
            </div>

          </div>
        </div>
      </div>
    </section>
   {{-- <section class="faq-wrapper common-gap">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center mb-4">
            <div class="common-title">
              <h3>{{$page->page_name}}</h3>
              <p>{!!$page->description!!}</p>
            </div>
          </div>
          
        </div>
      </div>
    </section> --}}
@endsection

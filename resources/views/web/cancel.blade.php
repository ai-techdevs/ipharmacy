{{-- @extends('layouts/master')
@section('title', 'Payment Failed')
@section('content')
<section class="mb-3 bg-light">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center py-2">
            <div class="page-title">Payment Failed</div>
            @include('partials/messages')
        </div>
    </div>
</section>

@endsection
@push('finc_scripts')
@endpush --}}






<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/etsfav.png') }}">
    <title>@yield('title', 'Eden The Store')</title>
    @hasSection('meta_description')
        <meta name="description" content="@yield('meta_description')">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('assets/vendors/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/vendors/bootstrap-icons/font/bootstrap-icons.css')}}">
    <script src="{{url('assets/vendors/jQuery/jquery-3.7.1.min.js')}}"></script>
    <link rel="stylesheet" href="{{url('assets/vendors/DataTables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/vendors/swiper/swiper-bundle.min.css')}}">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
  </head>
  <body class="finc-mobile">

 
    <section class="order-sucess">
      <div class="container">
        <div class="success-container fail">
          <h4>Payment Failed</h4>
          <i class="fa-solid fa-xmark"></i>
          <p class="fail">your last transaction was failed</p>
          <div class="order-details">
            {{-- <h5>your  order id is <a href="">#{{$order->order_no ??''}}</a></h5> --}}
            <p>Thank you for choosing Ipharmacy.</p>
          </div>
          <a href="{{route('index')}}" class="btn btn-danger">Back to Shop</a>
        </div>
      </div>
    </section>
   
        <script src="{{url('assets/vendors/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('assets/vendors/DataTables/datatables.min.js')}}"></script>
    <script src="{{url('assets/vendors/swiper/swiper-bundle.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

    

  </body>
</html>

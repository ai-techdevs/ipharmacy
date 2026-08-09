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
                            <li class="breadcrumb-item active" aria-current="page">Drugs Beginning With The Letter {{ $letter }} </li>
                        </ol>
                    </nav>
                    <h1>Drug Information</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="drug-information-details-wrapper common-gap">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <div class="common-title">
                    <h3>Drugs Beginning With The Letter {{ $letter }} </h3>
                </div>
            </div>

            @foreach ($medicines as $item)
            <div class="col-12 col-md-6 mb-3">
                <div class="drug-information-serv-list">
                    <div class="name">
                        {{-- <a href="{{ route('drug.detail', $item->slug)  }}">{{ $item->name }}</a> --}}
                        <a href="{{ route('drug.detail', ['letter' => strtolower($letter), 'slug' => $item->slug]) }}">
                            {{ $item->name }}
                        </a>
                    </div>
                    <div class="right-btn">
                        {{-- <a class="arrow-btn" href="{{ route('drug.detail', $item->slug)  }}"><i class="fa-solid fa-arrow-right"></i></a> --}}
                        <a class="arrow-btn" href="{{ route('drug.detail', ['letter' => strtolower($letter), 'slug' => $item->slug]) }}">
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                    </div>
                </div>
            </div>
            @endforeach

            <div class="col-12 mt-4">
                {{ $medicines->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</section>

@endsection

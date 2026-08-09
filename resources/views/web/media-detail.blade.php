@extends('web/layouts/master')

@section('content')
    <section class="inner-banner-wrapper">
        <div class="inner-banner-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <nav class="banner-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">CDC Media</li>
                            </ol>
                        </nav>
                        <h1>CDC Media</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="cdc-media-details-wrapper common-gap">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="heading">
                        <h3>{{ $cdc->title }}</h3>
                        <ul>
                            <li>{{ $cdc->author }}</li>
                            <li>{{ \Carbon\Carbon::parse($cdc->created_at)->format('jS F Y') }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="cdc-media-details-img">
                        <img class="img-fluid"
                            src="{{ !empty($cdc->image) && file_exists(public_path('storage/' . $cdc->image)) ? asset('storage/' . $cdc->image) : url('assets/images/cdc-media-img1.jpg') }}"
                            alt="">
                    </div>
                </div>
                <div class="col-12 col-md-8 mb-3 mb-md-4">
                    <div class="cdc-media-details-content">
                        {!! $cdc->description !!}
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <div class="comment-sidebar">
                        <h3>Comments</h3>
                        @if (count($cdc->comments) > 0)
                            @foreach ($cdc->comments as $cmt)
                                <div class="sidebar-comment-list">
                                    <div class="sidebar-comment-auth">
                                        <div class="auth-img">
                                            @if (is_file(public_path('storage/' . auth()->user()?->image)))
                                                <img class="img-fluid" src="{{ url('storage/' . auth()->user()?->image) }}"
                                                    alt="">
                                            @else
                                                <img class="img-fluid" src="{{ url('default-profile.jpg') }}"
                                                    alt="">
                                            @endif
                                            {{-- <img class="img-fluid" src="{{ url('assets/images/auth-img3.jpg') }}"
                                                alt=""> --}}
                                        </div>
                                        <div class="auth-dtls">
                                            <h4>{{ $cmt->name ?? '' }}</h4>
                                            @php
                                                $createdAt = \Carbon\Carbon::parse($cmt->created_at);
                                                $now = \Carbon\Carbon::now();

                                                $showRelativeUntil = $createdAt->diffInDays($now) < 30;
                                            @endphp
                                            <h6>
                                                @if ($showRelativeUntil)
                                                    {{ $createdAt->diffForHumans() }}
                                                @else
                                                    {{ $createdAt->format('jS M Y') }}
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                    <p>{{ $cmt->message }} </p>
                                </div>
                            @endforeach
                        @else
                            <div class="sidebar-comment-list">
                                <h5>No comments yet!</h5>
                            </div>
                        @endif
                        {{-- <div class="sidebar-comment-list">
                            <div class="sidebar-comment-auth">
                                <div class="auth-img">
                                    <img class="img-fluid" src="{{ url('assets/images/auth-img3.jpg') }}" alt="">
                                </div>
                                <div class="auth-dtls">
                                    <h4>Elizabeth May</h4>
                                    <h6>6h ago</h6>
                                </div>
                            </div>
                            <p>Donec ipsum leo, accumsan non rutrum nec, dignissim ut turpis. Integer nec consequat odio. In
                                libero justo, aliquet ac ultrices id, posuere eu nisi. </p>
                        </div>
                        <div class="sidebar-comment-list">
                            <div class="sidebar-comment-auth">
                                <div class="auth-img">
                                    <img class="img-fluid" src="{{ url('assets/images/auth-img3.jpg') }}" alt="">
                                </div>
                                <div class="auth-dtls">
                                    <h4>Elizabeth May</h4>
                                    <h6>6h ago</h6>
                                </div>
                            </div>
                            <p>Donec ipsum leo, accumsan non rutrum nec, dignissim ut turpis. Integer nec consequat odio. In
                                libero justo, aliquet ac ultrices id, posuere eu nisi. </p>
                        </div>
                        <div class="sidebar-comment-list">
                            <div class="sidebar-comment-auth">
                                <div class="auth-img">
                                    <img class="img-fluid" src="{{ url('assets/images/auth-img3.jpg') }}" alt="">
                                </div>
                                <div class="auth-dtls">
                                    <h4>Elizabeth May</h4>
                                    <h6>6h ago</h6>
                                </div>
                            </div>
                            <p>Donec ipsum leo, accumsan non rutrum nec, dignissim ut turpis. Integer nec consequat odio. In
                                libero justo, aliquet ac ultrices id, posuere eu nisi. </p>
                        </div>
                        <div class="sidebar-comment-list">
                            <div class="sidebar-comment-auth">
                                <div class="auth-img">
                                    <img class="img-fluid" src="{{ url('assets/images/auth-img3.jpg') }}" alt="">
                                </div>
                                <div class="auth-dtls">
                                    <h4>Elizabeth May</h4>
                                    <h6>6h ago</h6>
                                </div>
                            </div>
                            <p>Donec ipsum leo, accumsan non rutrum nec, dignissim ut turpis. Integer nec consequat odio. In
                                libero justo, aliquet ac ultrices id, posuere eu nisi. </p>
                        </div> --}}

                    </div>
                </div>
 @if (Session::has('success'))
                <div class="alert alert-success"><b>Success: </b>{{ Session::get('success') }}</div>
            @endif

            @if (Session::has('error'))
                <div class="alert alert-danger"><b>Error: </b> {{ Session::get('error') }}</div>
            @endif

                <form action="{{ route('cdc.comment.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="cdc_id" value="{{ $cdc->id }}"> {{-- assuming you're inside a CDC detail view --}}
                    <div class="col-12 col-md-10">
                        <div class="comment-form-wrap">
                            <div class="title mb-3">
                                <h3>Leave a Reply</h3>
                                <p>Your email address will not be published. Required fields are marked *</p>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Name *</label>
                                        <input class="form-control" type="text" name="name" placeholder="" required
                                            value="{{ auth()->check() ? auth()->user()->name . ' ' . auth()->user()->last_name : '' }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Email *</label>
                                        <input class="form-control" type="email" name="email" placeholder="" required
                                            value="{{ auth()->user()->email ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 mb-3">
                                    <div class="form-group">
                                        <label>Website</label>
                                        <input class="form-control" type="text" name="website" placeholder="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 mb-3">
                                    <div class="form-group">
                                        <label>Message *</label>
                                        <textarea class="form-control" name="message" rows="4" required></textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-md-12 mb-3">
                                    <div class="form-group">
                                        {{-- {!! NoCaptcha::display() !!} --}}
                                        {{-- @error('g-recaptcha-response')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror --}}
                                        <div class="g-recaptcha"
                                                            data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>
                                                        @error('g-recaptcha-response')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button class="btn common-btn1" type="submit">
                                        Submit Now <span><i class="fa-solid fa-arrow-right"></i></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                {{-- {!! NoCaptcha::renderJs() !!} --}}
            </div>
        </div>
    </section>
    <section class="related-blog-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="common-title">
                        <h3>Related Blogs</h3>
                    </div>
                </div>
                @if (!empty($cdc->related_blogs_ids))
                    @php
                        // $ids = explode(',', $cdc->related_blogs_ids);
                        //dd( $cdc->related_blogs_ids);
                        $ids = is_array($cdc->related_blogs_ids)
                            ? $cdc->related_blogs_ids
                            : (!empty($cdc->related_blogs_ids)
                                ? explode(',', $cdc->related_blogs_ids)
                                : []);
                    @endphp
                    @if (count($ids) > 0)
                        @foreach ($ids as $id)
                            @php
                                $relatedBlog = \App\Models\Cdc::find($id);
                            @endphp
                            <div class="col-12 col-md-4 mb-4">
                                <div class="cdc-media-list">
                                    <div class="img-box">
                                        <img class="img-fluid"
                                            src="{{ !empty($relatedBlog->image) && file_exists(public_path('storage/' . $relatedBlog->image)) ? asset('storage/' . $relatedBlog->image) : url('assets/images/cdc-media-img1.jpg') }}"
                                            alt="">
                                        <div class="cdc-btn-wrap">
                                            <a href="{{ route('media-detail', $relatedBlog->slug) }}" class="cdc-btn"><i
                                                    class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                    <div class="cdc-media-content">
                                        <h5>{{ $relatedBlog->author }}
                                            {{ \Carbon\Carbon::parse($relatedBlog->created_at)->format('jS F Y') }}
                                        </h5>
                                        <h4><a
                                                href="{{ route('media-detail', $relatedBlog->slug) }}">{{ $relatedBlog->title }}</a>
                                        </h4>
                                        <p>{!! Str::limit($relatedBlog->description, 100) !!} </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 col-md-12 mb-12 text-center">


                            <h5>Nothing found!</h5>

                        </div>
                    @endif
                @else
                    @if (count($cdcs) > 0)
                        @foreach ($cdcs as $cdc)
                            <div class="col-12 col-md-4 mb-4">
                                <div class="cdc-media-list">
                                    <div class="img-box">
                                        <img class="img-fluid"
                                            src="{{ !empty($cdc->image) && file_exists(public_path('storage/' . $cdc->image)) ? asset('storage/' . $cdc->image) : url('assets/images/cdc-media-img1.jpg') }}"
                                            alt="">
                                        <div class="cdc-btn-wrap">
                                            <a href="{{ route('media-detail', $cdc->slug) }}" class="cdc-btn"><i
                                                    class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                    <div class="cdc-media-content">
                                        <h5>{{ $cdc->author }}
                                            {{ \Carbon\Carbon::parse($cdc->created_at)->format('jS F Y') }}
                                        </h5>
                                        <h4><a href="{{ route('media-detail', $cdc->slug) }}">{{ $cdc->title }}</a>
                                        </h4>
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
                </div> --}}
                @endif

            </div>
        </div>
    </section>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

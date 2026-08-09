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
                                <li class="breadcrumb-item active" aria-current="page">Forum</li>
                            </ol>
                        </nav>
                        <h1>Forum</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="forum-wrapper">
        <div class="container">
            <div class="row">
                <!--<div class="col-12 mb-4">-->
                <!--    <div class="common-title">-->
                <!--        <h3>Forum</h3>-->
                <!--    </div>-->
                <!--</div>-->
                
                
                
                <div class="col-12 col-md-7 mb-4">
                    <div class="common-title">
                        <p>Welcome to the iPharmacy Forum — your community for health discussions, medicine information, wellness tips, disease awareness, and pharmacy support. Explore expert insights, share experiences, and connect with others on topics ranging from diabetes and heart health to vitamins, nutrition, and medication safety.</p>
                    </div>
                </div>
                <div class="col-12 col-md-5 mb-4">
                    <div class="right-img">
                        <img class="img-fluid w-75 float-end" src="{{url('assets/images/Digital-Photo-for-Forum-Main-Page.png')}}">
                    </div>
                </div>

                <div class="col-12">
                    @if (!empty($forums))
                        @foreach ($forums as $forum)
                            @php
                                $comments = $forum->comments;
                                $userImages = $comments->pluck('user.image')->toArray();
                                $forumUser = \App\Models\User::find($forum->user_id);
                            @endphp

                            <div class="forum-list" id="forum-{{ $forum->id }}">
                                <!-- Forum Heading -->
                                <div class="forum-heading-wrap">
                                    <div class="forum-heading">
                                        <h3>{{ $forum->name }}</h3>
                                        @if (!empty($forum->tag))
                                            @php $tags = explode(',', $forum->tag); @endphp
                                            <ul class="tag-list">
                                                @foreach ($tags as $tag)
                                                    <li><a href="#">#{{ $tag }}</a></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="bookmark-btn-wrap">
                                       {{--  <button class="bookmark-btn"><i class="fa-regular fa-bookmark"></i></button> --}}
                                    </div>
                                </div>

                                <!-- Main Comment -->
                                <div class="main-comment-wrap">
                                    <div class="main-comment">
                                        <div class="comment-author">
                                            <div class="auth-img">
                                                @if (is_file(public_path('storage/' . $forumUser?->image)))
                                                    <img class="img-fluid" src="{{ url('storage/' . $forumUser?->image) }}"
                                                        alt="">
                                                @else
                                                    <img class="img-fluid" src="{{ url('default-profile.jpg') }}"
                                                        alt="">
                                                @endif
                                            </div>
                                            <div class="auth-details">
                                                <h5>{{ $forumUser?->name }}</h5>
                                                <ul>
                                                    <li>{{ $forum?->created_at?->diffForHumans() }}</li>
                                                    <li>{{ $forum?->comments?->count() }} answers</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <p>{{ $forum->description }}</p>

                                        <!-- Comment Author Images -->
                                        {{-- @if (count($userImages) > 0)
                                            <div class="comment-author-list-wrap">
                                                <ul>
                                                    @foreach ($userImages as $image)
                                                        <li>
                                                            <div class="author-wrap   @if (!is_file(public_path('storage/' . $image))) name @endif">
                                                                @if (is_file(public_path('storage/' . $image)))
                                                                    <img class="img-fluid"
                                                                        src="{{ url('storage/' . $image) }}" alt="">
                                                                @else
                                                                    <h5>S</h5>
                                                                @endif
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                    @if ($forum->extra_users_count > 0)
                                                        <li class="extra-count">
                                                            <div class="author-count">+{{ $forum->extra_users_count }}
                                                            </div>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif --}}

                                        @if (count($userImages) > 0)
                                            <div class="comment-author-list-wrap">
                                                <ul>
                                                    @foreach ($comments as $comment)
                                                        @php
                                                            $user = $comment->user;
                                                            $userName = $user?->name ?? '';
                                                            $userInitial = strtoupper(substr($userName, 0, 1));
                                                            $image = $user?->image;
                                                        @endphp
                                                        <li>
                                                            <div
                                                                class="author-wrap @if (!is_file(public_path('storage/' . $image))) name @endif">
                                                                @if (!empty($image) && is_file(public_path('storage/' . $image)))
                                                                    <img class="img-fluid"
                                                                        src="{{ url('storage/' . $image) }}"
                                                                        alt="{{ $userName }}">
                                                                @else
                                                                    <h5>{{ $userInitial }}</h5>
                                                                @endif
                                                            </div>
                                                        </li>
                                                    @endforeach

                                                    @if ($forum->extra_users_count > 0)
                                                        <li class="extra-count">
                                                            <div class="author-count">+{{ $forum->extra_users_count }}
                                                            </div>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif

                                        <div class="horizontal-lines">
                                            <hr>
                                        </div>
                                    </div>

                                    <!-- Comment Actions -->
                                    <div class="comment-share-wrap">
                                        <div class="comment-share">
                                            <ul>
                                                <li>
                                                    <button class="like-btn" data-id="{{ $forum->id }}">
                                                        <i class="fa-regular fa-thumbs-up"></i>
                                                        <span class="like-count">{{ $forum?->likes?->count() }}</span> Like
                                                    </button>
                                                </li>
                                                <li>
                                                    <button class="accordion-btn">
                                                        <i class="fa-regular fa-message"></i> Comment
                                                    </button>
                                                </li>
                                                <li>

                                                    <a class="share-btn" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#ShareSocialModal"
                                                        data-forum-id="{{ $forum->id }}"
                                                        data-forum-title="{{ $forum->name }}">
                                                        <img class="img-fluid"
                                                            src="{{ url('assets/images/share-icon.svg') }}" alt="">
                                                        {{-- {{ $forum?->shares?->count() }}  --}}
                                                        Share
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="accordion-btn-wrap">
                                            <button class="accordion-btn"><i class="fa-solid fa-angle-down"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Comment Accordion -->
                                <div class="comment-accordion-body">



                                    <div id="comments-wrapper-{{ $forum->id }}">
                                        {{-- Initial comments will be loaded via AJAX --}}
                                    </div>


                                    <!-- Write Comment -->
                                    @if (\Auth::user())
                                        <div class="write-comment-wrap comment-section">
                                            <div class="write-comment-input">
                                                <input class="form-control comment-text" type="text"
                                                    placeholder="Write a comment...">
                                            </div>
                                            <div class="write-comment-btn">
                                                <ul>
                                                    <li>
                                                        <button class="send-btn" data-id="{{ $forum->id }}">
                                                            <img class="img-fluid"
                                                                src="{{ url('assets/images/send-icon.svg') }}"
                                                                alt="">
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endif

                                     @if ($forum->comments->count() > 0)
                                        <div class="text-center mb-2 mt-4">
                                            <button class="btn common-btn1 load-more-comments"
                                                data-forum="{{ $forum->id }}" data-offset="0">
                                                Load More <span><i class="fa-solid fa-arrow-down"></i></span>
                                            </button>
                                        </div>
                                    @endif
                                </div> <!-- end comment-accordion-body -->
                            </div> <!-- end forum-list -->
                        @endforeach
                    @endif

                    <!-- Pagination -->
                    <div class="pagination-wrap">
                        {{ $forums->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade share-social-modal-wrap" id="ShareSocialModal" tabindex="-1" aria-labelledby="ShareSocialLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa-solid fa-xmark"></i></button>
                <div class="modal-body">
                    <div class="title">
                        <h3>Share</h3>
                    </div>
                    <div class="social-media-wrap">
                        <ul>
                            <li><a href="#" target="_blank" id="share-facebook"><img class="img-fluid"
                                        src="{{ asset('assets/images/social-icon-facebook.png') }}" alt=""></a>
                            </li>
                            <li><a href="#" id="share-email"><img class="img-fluid"
                                        src="{{ asset('assets/images/social-icon-email.png') }}" alt=""></a></li>
                            <li><a href="#" target="_blank" id="share-twitter"><img class="img-fluid"
                                        src="{{ asset('assets/images/social-icon-twitter.png') }}" alt=""></a>
                            </li>
                            <li><a href="#" target="_blank" id="share-linkedin"><img class="img-fluid"
                                        src="{{ asset('assets/images/social-icon-linkedin.png') }}" alt=""></a>
                            </li>
                            <li><a href="#" target="_blank" id="share-whatsapp"><img class="img-fluid"
                                        src="{{ asset('assets/images/social-icon-whatsapp.png') }}" alt=""></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <section class="forum-wrapper common-gap">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="common-title">
                        <h3>Forum</h3>
                    </div>
                </div>
                <div class="col-12">
                    <div class="forum-list">
                        <div class="forum-heading-wrap">
                            <div class="forum-heading">
                                <h3>Smart choice begin with drug search?</h3>
                                <ul class="tag-list">
                                    <li><a href="#">#medcine</a></li>
                                    <li><a href="#">#information</a></li>
                                    <li><a href="#">#drug</a></li>
                                </ul>
                            </div>
                            <div class="bookmark-btn-wrap">
                                <button class="bookmark-btn"><i class="fa-regular fa-bookmark"></i></button>
                            </div>
                        </div>
                        <div class="main-comment-wrap">
                            <div class="main-comment">
                                <div class="comment-author">
                                    <div class="auth-img">
                                        <img class="img-fluid" src="images/auth-img1.jpg" alt="">
                                    </div>
                                    <div class="auth-details">
                                        <h5>Calina Smith </h5>
                                        <ul>
                                            <li>12h ago</li>
                                            <li>12 answers</li>
                                        </ul>
                                    </div>
                                </div>
                                <p>Donec ipsum leo, accumsan non rutrum nec, dignissim ut turpis. Integer nec consequat
                                    odio. In libero justo, aliquet ac ultrices id, posuere eu nisi. Phasellus dolor urna,
                                    auctor vitae consequat ac, sagittis quis tortor. Ut auctor, lorem in consectetur
                                    rhoncus, nisi dolor venenatis erat, id luctus turpis nibh et nulla.</p>
                                <div class="comment-author-list-wrap">
                                    <ul>

                                        <li>
                                            <div class="author-wrap name">
                                                <h5>S</h5>
                                            </div>
                                        </li>
                                        <!-- <li>
                                <div class="author-wrap">
                                  <img class="img-fluid" src="images/auth-img3.jpg" alt="">
                                </div>
                              </li>
                              <li>
                                <div class="author-wrap">
                                  <img class="img-fluid" src="images/auth-img4.jpg" alt="">
                                </div>
                              </li>
                              <li>
                                <div class="author-wrap">
                                  <img class="img-fluid" src="images/auth-img5.jpg" alt="">
                                </div>
                              </li>
                              <li>
                                <div class="author-wrap">
                                  <img class="img-fluid" src="images/auth-img6.jpg" alt="">
                                </div>
                              </li> -->
                                        <li>
                                            <div class="author-count">
                                                +12
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="horizontal-lines">
                                    <hr>
                                </div>
                            </div>
                            <div class="comment-share-wrap">
                                <div class="comment-share">
                                    <ul>
                                        <li>
                                            <button class="like-btn">
                                                <i class="fa-regular fa-thumbs-up"></i> 8 Like
                                            </button>
                                        </li>
                                        <li>


                                            <button class="accordion-btn">
                                                <i class="fa-regular fa-message"></i>
                                                5 Comment
                                            </button>

                                        </li>
                                        <li>
                                            <button class="share-btn">
                                                <img class="img-fluid" src="images/share-icon.svg" alt=""> 1
                                                Share
                                            </button>
                                        </li>


                                    </ul>
                                </div>
                                <div class="accordion-btn-wrap">
                                    <button class="accordion-btn">
                                        <i class="fa-solid fa-angle-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- comment accordion start -->
                        <div class="comment-accordion-body">
                            <div class="sub-main-comment-wrap">
                                <div class="auth-img">
                                    <img class="img-fluid" src="images/auth-img3.jpg" alt="">
                                </div>
                                <div class="sub-auth-details">
                                    <h4>Edward Jenar</h4>
                                    <p>Donec ipsum leo, accumsan non rutrum nec</p>
                                    <div class="comment-count">
                                        <i class="fa-regular fa-message"></i> 1 Comment
                                        <i class="fa-solid fa-calendar-days"></i> 12.30am
                                    </div>
                                </div>
                            </div>
                            <div class="sub-main-comment-wrap">
                                <div class="auth-img">
                                    <img class="img-fluid" src="images/auth-img3.jpg" alt="">
                                </div>
                                <div class="sub-auth-details">
                                    <h4>Edward Jenar</h4>
                                    <p>Donec ipsum leo, accumsan non rutrum nec</p>
                                    <div class="comment-count">
                                        <i class="fa-regular fa-message"></i> 2 Comment
                                        <i class="fa-solid fa-calendar-days"></i> 12.40am
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mb-2">
                                <button href="#" class="btn common-btn1">Load More <span><i
                                            class="fa-solid fa-arrow-down"></i></span></button>
                            </div>
                            <!-- Write comments wrap -->
                            <div class="write-comment-wrap">
                                <div class="write-comment-input">
                                    <input class="form-control" type="text" placeholder="Write a comment...">
                                </div>
                                <div class="write-comment-btn">
                                    <ul>
                                        <li>
                                            <button>
                                                <img class="img-fluid" src="images/emoji-icon.svg" alt="">
                                            </button>
                                        </li>
                                        <li>
                                            <button>
                                                <img class="img-fluid" src="images/attach-icon.svg" alt="">
                                            </button>
                                        </li>
                                        <li>
                                            <button class="send-btn">
                                                <img class="img-fluid" src="images/send-icon.svg" alt="">
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Write comments wrap end -->

                        </div>
                        <!-- comment accordion end -->
                    </div>
                    <!-- ######### -->

                    <div class="forum-list">
                        <div class="forum-heading-wrap">
                            <div class="forum-heading">
                                <h3>Smart choice begin with drug search?</h3>
                                <ul class="tag-list">
                                    <li><a href="#">#medcine</a></li>
                                    <li><a href="#">#information</a></li>
                                    <li><a href="#">#drug</a></li>
                                </ul>
                            </div>
                            <div class="bookmark-btn-wrap">
                                <button class="bookmark-btn"><i class="fa-regular fa-bookmark"></i></button>
                            </div>
                        </div>
                        <div class="main-comment-wrap">
                            <div class="main-comment">
                                <div class="comment-author">
                                    <div class="auth-img">
                                        <img class="img-fluid" src="images/auth-img1.jpg" alt="">
                                    </div>
                                    <div class="auth-details">
                                        <h5>Calina Smith </h5>
                                        <ul>
                                            <li>12h ago</li>
                                            <li>12 answers</li>
                                        </ul>
                                    </div>
                                </div>
                                <p>Donec ipsum leo, accumsan non rutrum nec, dignissim ut turpis. Integer nec consequat
                                    odio. In libero justo, aliquet ac ultrices id, posuere eu nisi. Phasellus dolor urna,
                                    auctor vitae consequat ac, sagittis quis tortor. Ut auctor, lorem in consectetur
                                    rhoncus, nisi dolor venenatis erat, id luctus turpis nibh et nulla.</p>
                                <div class="comment-author-list-wrap">
                                    <ul>
                                        <li>
                                            <div class="author-wrap">
                                                <img class="img-fluid" src="images/auth-img2.jpg" alt="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="author-wrap">
                                                <img class="img-fluid" src="images/auth-img3.jpg" alt="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="author-wrap">
                                                <img class="img-fluid" src="images/auth-img4.jpg" alt="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="author-wrap">
                                                <img class="img-fluid" src="images/auth-img5.jpg" alt="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="author-wrap">
                                                <img class="img-fluid" src="images/auth-img6.jpg" alt="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="author-count">
                                                +12
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="horizontal-lines">
                                    <hr>
                                </div>
                            </div>
                            <div class="comment-share-wrap">
                                <div class="comment-share">
                                    <ul>
                                        <li>
                                            <button class="like-btn">
                                                <i class="fa-regular fa-thumbs-up"></i> 8 Like
                                            </button>
                                        </li>
                                        <li>
                                            <button class="comment-btn">
                                                <i class="fa-regular fa-message"></i> 5 Comment
                                            </button>
                                        </li>
                                        <li>
                                            <button class="share-btn">
                                                <img class="img-fluid" src="images/share-icon.svg" alt=""> 1
                                                Share
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="accordion-btn-wrap">
                                    <button class="accordion-btn">
                                        <i class="fa-solid fa-angle-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- comment accordion start -->
                        <div class="comment-accordion-body">
                            <div class="sub-main-comment-wrap">
                                <div class="auth-img">
                                    <img class="img-fluid" src="images/auth-img3.jpg" alt="">
                                </div>
                                <div class="sub-auth-details">
                                    <h4>Edward Jenar</h4>
                                    <p>Donec ipsum leo, accumsan non rutrum nec</p>
                                    <div class="comment-count">
                                        <i class="fa-regular fa-message"></i> 1 Comment
                                    </div>
                                </div>
                            </div>


                            <!-- Write comments wrap -->
                            <div class="write-comment-wrap">
                                <div class="write-comment-input">
                                    <input class="form-control" type="text" placeholder="Write a comment...">
                                </div>
                                <div class="write-comment-btn">
                                    <ul>
                                        <li>
                                            <button>
                                                <img class="img-fluid" src="images/emoji-icon.svg" alt="">
                                            </button>
                                        </li>
                                        <li>
                                            <button>
                                                <img class="img-fluid" src="images/attach-icon.svg" alt="">
                                            </button>
                                        </li>
                                        <li>
                                            <button class="send-btn">
                                                <img class="img-fluid" src="images/send-icon.svg" alt="">
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Write comments wrap -->

                        </div>
                        <!-- comment accordion end -->
                    </div>
                    <!-- ##### -->

                    <div class="forum-list">
                        <div class="forum-heading-wrap">
                            <div class="forum-heading">
                                <h3>Smart choice begin with drug search?</h3>
                                <ul class="tag-list">
                                    <li><a href="#">#medcine</a></li>
                                    <li><a href="#">#information</a></li>
                                    <li><a href="#">#drug</a></li>
                                </ul>
                            </div>
                            <div class="bookmark-btn-wrap">
                                <button class="bookmark-btn"><i class="fa-regular fa-bookmark"></i></button>
                            </div>
                        </div>
                        <div class="main-comment-wrap">
                            <div class="main-comment">
                                <div class="comment-author">
                                    <div class="auth-img">
                                        <img class="img-fluid" src="images/auth-img1.jpg" alt="">
                                    </div>
                                    <div class="auth-details">
                                        <h5>Calina Smith </h5>
                                        <ul>
                                            <li>12h ago</li>
                                            <li>12 answers</li>
                                        </ul>
                                    </div>
                                </div>
                                <p>Donec ipsum leo, accumsan non rutrum nec, dignissim ut turpis. Integer nec consequat
                                    odio. In libero justo, aliquet ac ultrices id, posuere eu nisi. Phasellus dolor urna,
                                    auctor vitae consequat ac, sagittis quis tortor. Ut auctor, lorem in consectetur
                                    rhoncus, nisi dolor venenatis erat, id luctus turpis nibh et nulla.</p>
                                <div class="comment-author-list-wrap">
                                    <ul>
                                        <li>
                                            <div class="author-wrap">
                                                <img class="img-fluid" src="images/auth-img2.jpg" alt="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="author-wrap">
                                                <img class="img-fluid" src="images/auth-img3.jpg" alt="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="author-wrap">
                                                <img class="img-fluid" src="images/auth-img4.jpg" alt="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="author-wrap">
                                                <img class="img-fluid" src="images/auth-img5.jpg" alt="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="author-wrap">
                                                <img class="img-fluid" src="images/auth-img6.jpg" alt="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="author-count">
                                                +12
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="horizontal-lines">
                                    <hr>
                                </div>
                            </div>
                            <div class="comment-share-wrap">
                                <div class="comment-share">
                                    <ul>
                                        <li>
                                            <button class="like-btn">
                                                <i class="fa-regular fa-thumbs-up"></i> 8 Like
                                            </button>
                                        </li>
                                        <li>
                                            <button class="comment-btn">
                                                <i class="fa-regular fa-message"></i> 5 Comment
                                            </button>
                                        </li>
                                        <li>
                                            <button class="share-btn">
                                                <img class="img-fluid" src="images/share-icon.svg" alt=""> 1
                                                Share
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="accordion-btn-wrap">
                                    <button class="accordion-btn">
                                        <i class="fa-solid fa-angle-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- comment accordion start -->
                        <div class="comment-accordion-body">
                            <div class="sub-main-comment-wrap">
                                <div class="auth-img">
                                    <img class="img-fluid" src="images/auth-img3.jpg" alt="">
                                </div>
                                <div class="sub-auth-details">
                                    <h4>Edward Jenar</h4>
                                    <p>Donec ipsum leo, accumsan non rutrum nec</p>
                                    <div class="comment-count">
                                        <i class="fa-regular fa-message"></i> 1 Comment
                                    </div>
                                </div>
                            </div>

                            <!-- Write comments wrap -->
                            <div class="write-comment-wrap">
                                <div class="write-comment-input">
                                    <input class="form-control" type="text" placeholder="Write a comment...">
                                </div>
                                <div class="write-comment-btn">
                                    <ul>
                                        <li>
                                            <button>
                                                <img class="img-fluid" src="images/emoji-icon.svg" alt="">
                                            </button>
                                        </li>
                                        <li>
                                            <button>
                                                <img class="img-fluid" src="images/attach-icon.svg" alt="">
                                            </button>
                                        </li>
                                        <li>
                                            <button class="send-btn">
                                                <img class="img-fluid" src="images/send-icon.svg" alt="">
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Write comments wrap -->

                        </div>
                        <!-- comment accordion end -->
                    </div>

                    <div class="pagination-wrap">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link prev" href="#">
                                    <i class="fa-solid fa-angle-left"></i>
                                </a>
                            </li>
                            <li class="page-item"><a class="page-link active" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link next" href="#">
                                    <i class="fa-solid fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section> --}}
@endsection
@push('scripts')
    <script>
        $(document).on('click', '.like-btn', function() {
            let forumId = $(this).data('id');
            let btn = $(this);
            let url = "{!! route('forum.like', ':id') !!}";
            url = url.replace(':id', forumId);

            $.ajax({
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'POST',
                success: function(response) {
                    if (response.status) {
                       
                        btn.find('.like-count').text(response.likes_count);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Something went wrong.');
                }
            });
        });

        $(document).on('click', '.send-btn', function() {
            let forumId = $(this).data('id');
            let btn = $(this);
            let textArea = btn.closest('.comment-section').find('.comment-text');
            let commentList = btn.closest('.comment-accordion-body');
            let commentText = textArea.val();
            let url = "{!! route('forum.comment', ':id') !!}";
            url = url.replace(':id', forumId);

            if (!commentText.trim()) {
                alert("Please write a comment.");
                return;
            }

            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    comment: commentText
                },
                success: function(response) {
                    if (response.status) {
                        let commentHtml = `
                    <div class="sub-main-comment-wrap">
                                  <div class="auth-img">
                                            <img class="img-fluid" src="${response.comment.user_avatar}" alt="">
                                    </div>
                                    <div class="sub-auth-details">
                                        <h4>${response.comment.user_name}</h4>
                                        <p>${response.comment.comment}</p>
                                         <div class="comment-count">
                <i class="fa-solid fa-calendar-days"></i>
               Just Now
            </div>
                                    </div>
                        </div>`;


                        commentList.find('.write-comment-wrap').before(commentHtml);

                        textArea.val('');
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert("Something went wrong.");
                }
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.load-more-comments');

            buttons.forEach(btn => {
                const forumId = btn.dataset.forum;
                let offset = parseInt(btn.dataset.offset);
                const wrapper = document.getElementById('comments-wrapper-' + forumId);


                function loadComments() {
                    const url = '{{ route('forum.comments', ':id') }}'.replace(':id', forumId) +
                        '?offset=' + offset;

                    fetch(url)
                        .then(response => response.text())
                        .then(data => {
                            if (data.trim() === '') {
                                // No more comments
                                btn.style.display = 'none';
                            } else {
                                wrapper.insertAdjacentHTML('beforeend', data);
                                offset += 2;
                                btn.dataset.offset = offset;
                            }
                        });
                }


                loadComments();


                btn.addEventListener('click', loadComments);
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const shareModal = document.getElementById('ShareSocialModal');

            shareModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Button that triggered the modal
                const forumId = button.getAttribute('data-forum-id');
                const forumTitle = button.getAttribute('data-forum-title');

                const rawUrl = encodeURIComponent(window.location.origin + window.location.pathname +
                    '#forum-' + forumId);
                const encodedTitle = encodeURIComponent(forumTitle);

                // Update all social links
                document.getElementById('share-facebook').href =
                    `https://www.facebook.com/sharer/sharer.php?u=${rawUrl}`;
                document.getElementById('share-email').href =
                    `mailto:?subject=${forumTitle}&body=${forumTitle} ${window.location.origin + window.location.pathname +
                    '#forum-' + forumId}`;
                document.getElementById('share-twitter').href =
                    `https://twitter.com/intent/tweet?url=${rawUrl}&text=${encodedTitle}`;
                document.getElementById('share-linkedin').href =
                    `https://www.linkedin.com/sharing/share-offsite/?url=${rawUrl}`;
                document.getElementById('share-whatsapp').href =
                    `https://wa.me/?text=${encodedTitle} ${rawUrl}`;
            });
        });
    </script>
@endpush

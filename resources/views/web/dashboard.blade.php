<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>ipharmacy</title>
    <!-- Bootstrap -->
    <link rel="shortcut icon" href="{{ url('assets/images/favicon.jpg')}}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- fontawesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"
        media="all">
    <!-- fontawesome -->
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link href="{{ url('assets/css/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/aos.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/menu.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/style.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/responsive.css') }}" rel="stylesheet" media="all">


</head>

<body>

    <section class="user-dashboard-wrapper">
        <div class="user-dashboard-inner-wrap">
            <div class="dashboard-sidebar">
                <div class="db-sidebar-inner">
                    <div class="logo-wrap">
                        <a href="{{ route('index') }}">
                            <img class="img-fluid" src="{{ url('assets/images/logo.png') }}" alt="">
                        </a>
                    </div>
                    <div class="db-menu-wrap">
                        <ul>
                            <li class="active">
                                <a href="{{ route('dashboard') }}"> <span class="icon"> <img class="img-fluid"
                                            src="{{ asset('assets/images/db-dashboard-home.svg') }}" alt="">
                                    </span> Dashboard</a>
                            </li>
                            <li>
                                <a href="{{ route('drugs.info') }}"> <span class="icon"> <img class="img-fluid"
                                            src="{{ asset('assets/images/db-drug-information-icon.svg') }}"
                                            alt=""> </span> Drug Information</a>
                            </li>
                            <li>
                                <a href="{{ route('forum') }}"> <span class="icon"> <img class="img-fluid"
                                            src="{{ asset('assets/images/db-forum-icon.svg') }}" alt="">
                                    </span> Forum</a>
                            </li>
                            <li>
                                <a href="{{ route('media') }}"> <span class="icon"> <img class="img-fluid"
                                            src="{{ asset('assets/images/db-cdc-media-icon.svg') }}" alt="">
                                    </span> CDC Media</a>
                            </li>
                            <li>
                                <a href="{{ route('faq') }}"> <span class="icon"> <img class="img-fluid"
                                            src="{{ asset('assets/images/db-faqs-icon.svg') }}" alt=""> </span>
                                    FAQs</a>
                            </li>
                            
                        </ul>
                    </div>
                </div>
                <div class="logout-btn-wrap">

                    <a href="{{route('index')}}" class="logout-btn"
                    >
                        <i class="fa-solid fa-arrow-right"></i> Go to Home
                    </a>
                    {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form> --}}

                </div>
            </div>
            <div class="dashboard-body">
                <div class="db-header-wrapper">
                    <div class="header-left-search">
                        <div class="db-head-search">
                            <form action="{{ route('drugs.search') }}" method="GET" target="_blank">
                                <div class="search-box-inner">
                                    <div class="search-btn-wrp">
                                        <button class="search-btn" type="submit"><i
                                                class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                    <div class="search-box">
                                        <input class="form-control" type="search" name="query"
                                            placeholder="Search drug information..." value="{{ request('query') }}">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="user-notification-wrap">
                        <ul class="user-notification-inner">
                            {{-- <li class="notification-wrap">
                                <a href="#" class="notification-btn">
                                    <i class="fa-regular fa-bell"></i>
                                </a>
                            </li> --}}
                            <li class="user-dropdown">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="user-img">
                                           @if (is_file(public_path('storage/' . auth()->user()?->image)))
                                                        
                                                            <img class="img-fluid"
                                                                src="{{ url('storage/' . auth()->user()?->image) }}"
                                                                alt="">
                                                       
                                                    @else
                                                        
                                                            <img class="img-fluid"
                                                                src="{{ url('default-profile.jpg') }}"
                                                                alt="">
                                                        
                                                    @endif
                                            {{-- <img class="img-fluid" src="{{ url('assets/images/auth-img2.jpg') }}"
                                                alt=""> --}}
                                        </span>
                                        <div class="user-details">
                                            <h5>{{ auth()->user()->name }} {{ auth()->user()->last_name }}</h5>
                                            <p>Customer</p>
                                        </div>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="{{ route('profile') }}">Account
                                                Setting</a></li>
                                                <li>
    <a class="dropdown-item" href="{{ route('password.change') }}">
        Change Password
    </a>
</li>
                                                <li><a class="dropdown-item" href="{{ route('subscription.list') }}">Donations</a></li>
                                        <li> <a href="#" class="dropdown-item"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Log out
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <button class="sidebar-tigger">
                                    <i class="fa-solid fa-bars"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="db-body-inner">
                    <div class="row">
                        <div class="col-12 col-lg-6 mb-4">
                            {{-- <div class="type-drug-name-wrap">
                  <div class="heading">
                    <div class="title">
                      <h4>Type Drug Name</h4>
                    </div>
                    <div class="share-btn-wrap">
                      <button class="share-btn" data-bs-toggle="modal" data-bs-target="#ShareSocialModal"><img class="img-fluid" src="images/share-icon.svg" alt=""></button>
                    </div>
                  </div>
                  <div class="type-drug-input">
                    <select class="form-select">
                      <option>Benadryl Oral</option>
                      <option>Benadryl Oral</option>
                      <option>Benadryl Oral</option>
                    </select>
                  </div>
                </div>
                 --}}
                            <div class="db-forum-wrap">
                                <div class="db-forum-head">
                                    <div class="title">
                                        <h3>Forum</h3>
                                    </div>
                                    <div class="btn-wrap">
                                        <button class="btn common-btn2" href="#" data-bs-toggle="modal"
                                            data-bs-target="#AddForumModal"> Add Forum </button>
                                    </div>
                                </div>
                                @if (!empty($forum))
                                    <div class="forum-list">
                                        <div class="forum-heading-wrap">
                                            <div class="forum-heading">
                                                <h3>{{ $forum->name }}</h3>
                                                @if (!empty($forum->tag))
                                                    @php
                                                        $tags = explode(',', $forum->tag);
                                                    @endphp

                                                    <ul class="tag-list">
                                                        @foreach ($tags as $tag)
                                                            <li><a href="#">#{{ $tag }}</a></li>
                                                        @endforeach
                                                    </ul>


                                                @endif

                                            </div>

                                        </div>
                                        <div class="main-comment-wrap">
                                            <div class="main-comment">
                                                <div class="comment-author">

                                                    @php
                                                        $user = \App\Models\User::find($forum->user_id ?? null);
                                                        //dd(  $user );
                                                    @endphp

                                                    @if (is_file(public_path('storage/' . $user?->image)))
                                                        <div class="auth-img">
                                                            <img class="img-fluid"
                                                                src="{{ url('storage/' . $user?->image) }}"
                                                                alt="">
                                                        </div>
                                                    @else
                                                        <div class="auth-img">
                                                            <img class="img-fluid"
                                                                src="{{ url('default-profile.jpg') }}"
                                                                alt="">
                                                        </div>
                                                    @endif
                                                    <div class="auth-details">
                                                        <h5>{{ $forum->user->name ?? '' }} </h5>
                                                        <ul>
                                                            <li>{{ $forum->created_at->diffForHumans() }}</li>
                                                            <li>{{ $forum->comments->count() }} answers</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <p>{{ $forum->description }}</p>
                                                <div class="comment-author-list-wrap">
                                                    {{-- <ul>
                                <li>
                                <div class="author-wrap">
                                    <img class="img-fluid" src="{{url('assets/images/auth-img2.jpg')}}" alt="">
                                </div>
                                </li>
                                <li>
                                <div class="author-wrap">
                                    <img class="img-fluid" src="{{url('assets/images/auth-img3.jpg')}}" alt="">
                                </div>
                                </li>
                                <li>
                                <div class="author-wrap">
                                    <img class="img-fluid" src="{{url('assets/images/auth-img4.jpg')}}" alt="">
                                </div>
                                </li>
                                <li>
                                <div class="author-wrap">
                                    <img class="img-fluid" src="{{url('assets/images/auth-img5.jpg')}}" alt="">
                                </div>
                                </li>
                                <li>
                                <div class="author-wrap">
                                    <img class="img-fluid" src="{{url('assets/images/auth-img6.jpg')}}" alt="">
                                </div>
                                </li>
                                <li>
                                <div class="author-count">
                                    +12
                                </div>
                                </li>
                            </ul> --}}
                                                </div>
                                                <div class="horizontal-lines">
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="comment-share-wrap">
                                                <div class="comment-share">
                                                    <ul>
                                                        <li>
                                                            <button class="like-btn" data-id="{{ $forum->id }}">
                                                                <i class="fa-regular fa-thumbs-up"></i>
                                                                <span
                                                                    class="like-count">{{ $forum?->likes?->count() }}</span>
                                                                Like
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button class="accordion-btn">
                                                                <i class="fa-regular fa-message"></i> Comment
                                                            </button>
                                                        </li>
                                                        <li>

                                                            <a class="share-btn" href="#"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#ShareSocialModal"
                                                                data-forum-id="{{ $forum->id }}"
                                                                data-forum-title="{{ $forum->name }}">
                                                                <img class="img-fluid"
                                                                    src="{{ url('assets/images/share-icon.svg') }}"
                                                                    alt="">
                                                                {{-- {{ $forum?->shares?->count() }}  --}}
                                                                Share
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="accordion-btn-wrap">
                                                    <button class="accordion-btn"><i
                                                            class="fa-solid fa-angle-down"></i></button>
                                                </div>

                                            </div>
                                        </div>
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
                                                                <button class="send-btn"
                                                                    data-id="{{ $forum->id }}">
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
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>

                        <div class="col-12 col-lg-6">

                            @if (!empty($cdc))
                                <div class="db-cdc-media-wrap">
                                    <h3>CDC Media</h3>
                                    <div class="db-cdc-media">
                                        <div class="img-box">
                                            <img class="img-fluid"
                                                src="{{ !empty($cdc->image) && file_exists(public_path('storage/' . $cdc->image)) ? asset('storage/' . $cdc->image) : url('assets/images/cdc-media-img1.jpg') }}"
                                                alt="">
                                        </div>
                                        <div class="db-cdc-media-content">
                                            <ul>
                                                <li>{{ $cdc->author }}</li>
                                                <li>{{ \Carbon\Carbon::parse($cdc->created_at)->format('jS F Y') }}
                                                </li>
                                            </ul>
                                            <h4><a
                                                    href="{{ route('media-detail', $cdc->slug) }}">{{ $cdc->title }}</a>
                                            </h4>
                                            <p>{!! Str::limit($cdc->description, 100) !!} </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="db-faq-wrap">
                                <h3>Frequently Asked Questions </h3>
                                @if (!empty($faqs))
                                    <div class="faq-wrap">
                                        <div class="accordion" id="FAQaccordion">
                                            @foreach ($faqs as $key => $faq)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading{{ $key + 1 }}">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse{{ $key + 1 }}"
                                                            aria-expanded="true"
                                                            aria-controls="collapse{{ $key + 1 }}">
                                                            {{ $faq->question }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapse{{ $key + 1 }}"
                                                        class="accordion-collapse collapse"
                                                        aria-labelledby="heading{{ $key + 1 }}"
                                                        data-bs-parent="#FAQaccordion">
                                                        <div class="accordion-body">
                                                            <p>{{ $faq->answer }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- share social media -->
    <div class="modal fade share-social-modal-wrap" id="ShareSocialModal" tabindex="-1"
        aria-labelledby="ShareSocialLabel" aria-hidden="true">
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
                                        src="{{ asset('assets/images/social-icon-facebook.png') }}"
                                        alt=""></a>
                            </li>
                            <li><a href="#" id="share-email"><img class="img-fluid"
                                        src="{{ asset('assets/images/social-icon-email.png') }}" alt=""></a>
                            </li>
                            <li><a href="#" target="_blank" id="share-twitter"><img class="img-fluid"
                                        src="{{ asset('assets/images/social-icon-twitter.png') }}"
                                        alt=""></a>
                            </li>
                            <li><a href="#" target="_blank" id="share-linkedin"><img class="img-fluid"
                                        src="{{ asset('assets/images/social-icon-linkedin.png') }}"
                                        alt=""></a>
                            </li>
                            <li><a href="#" target="_blank" id="share-whatsapp"><img class="img-fluid"
                                        src="{{ asset('assets/images/social-icon-whatsapp.png') }}"
                                        alt=""></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- add forum start -->
    <div class="modal fade add-forum-modal-wrap" id="AddForumModal" tabindex="-1" aria-labelledby="AddForumLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa-solid fa-xmark"></i></button>
                <div class="modal-body">

                    <div class="title">
                        <h3> Add Forum </h3>
                    </div>
                    <div id="message"></div>

                    <div class="add-forum-wrap">
                        <form id="forumForm" method="POST">
                            <div class="form-group mb-3">
                                <label>Name</label>
                                <input class="form-control" name="name" id="name" type="text"
                                    placeholder="|" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Tag</label>
                                <input class="form-control" name="tag" id="tag" type="text"
                                    placeholder="|" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Description</label>
                                <textarea class="form-control" name="description" id="description" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <input class="btn common-btn2" type="submit" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{ url('assets/js/slick.min.js') }}"></script>
    <script src="{{ url('assets/js/aos.js') }}"></script>
    <script src="{{ url('assets/js/menu.js') }}"></script>
    <script src="{{ url('assets/js/external.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#forumForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{!! route('forum.store') !!}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    data: $('#forumForm').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            $('#message').html(
                                `<div class="alert alert-success">${response.message}</div>`
                            );
                            $('#forumForm')[0].reset();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });

            $('#AddForumModal').on('show.bs.modal', function(event) {
                $('#message').html("");
            });
        });


      
    </script>

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

                // const rawUrl = encodeURIComponent(window.location.origin + window.location.pathname +
                //     '#forum-' + forumId);
                const rawUrl = encodeURIComponent("{{ route('forum') }}#forum-" + forumId);
                const encodedTitle = encodeURIComponent(forumTitle);

                // Update all social links
                document.getElementById('share-facebook').href =
                    `https://www.facebook.com/sharer/sharer.php?u=${rawUrl}`;
                document.getElementById('share-email').href =
        `mailto:?subject=${forumTitle}&body=${forumTitle} {{ route('forum') }}#forum-${forumId}`;
                document.getElementById('share-twitter').href =
                    `https://twitter.com/intent/tweet?url=${rawUrl}&text=${encodedTitle}`;
                document.getElementById('share-linkedin').href =
                    `https://www.linkedin.com/sharing/share-offsite/?url=${rawUrl}`;
                document.getElementById('share-whatsapp').href =
                    `https://wa.me/?text=${encodedTitle} ${rawUrl}`;
            });
        });
    </script>
</body>

</html>

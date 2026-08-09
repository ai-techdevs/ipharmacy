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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.bootstrap5.min.css">

    <link href="{{ url('assets/css/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/aos.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/menu.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/style.css') }}" rel="stylesheet" media="all">
    <link href="{{ url('assets/css/responsive.css') }}" rel="stylesheet" media="all">
 @stack('third_party_stylesheets')

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
                                            
                                        </span>
                                        <div class="user-details">
                                            <h5>{{ auth()->user()->name }} {{ auth()->user()->last_name }}</h5>
                                            <p>Customer</p>
                                        </div>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="{{ route('profile') }}">Account
                                                Setting</a></li>
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

                      <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <h1>My Transactions </h1>
                                    </div>
                                    
                                </div>
                



                    <div class="clearfix"></div>
                
                                <div class="card pt-4">
                                    @push('third_party_stylesheets')
                                    @include('admin.layouts.datatables_css')
                                    @endpush
                
                                    <div class="card-body pt-0 pb-4 pl-4 pr-4">
                                        {!! $dataTable->table(['class' => 'table table-striped table-bordered align-middle text-center', 'width' => '100%']) !!}

                                    </div>
                                    {{-- <div class="card-body">
                                        <a href="{{route('product.display')}}" class="btn btn-primary"> Back </a>
                                    </div> --}}
                
                                    @push('third_party_scripts')
                                    @include('admin.layouts.datatables_js')
                                    {!! $dataTable->scripts() !!}
                                    @endpush
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
    @stack('third_party_scripts')
</body>

</html>

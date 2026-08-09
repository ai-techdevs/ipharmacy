@foreach ($comments as $item)
    @php
        $user = \App\Models\User::find($item->user_id);
        $userName = $user?->name ?? '';
        $userInitial = strtoupper(substr($userName, 0, 1));
    @endphp
    <div class="sub-main-comment-wrap">
        <div class="auth-img">
            @if (!empty($user?->image) && is_file(public_path('storage/' . $user->image)))
                <img class="img-fluid" src="{{ url('storage/' . $user->image) }}" alt="{{ $userName }}">
            @else
                <img class="img-fluid" src="{{ url('default-profile.jpg') }}"
                                                            alt="">
            @endif
        </div>
        <div class="sub-auth-details">
            <h4>{{ $user?->name }}</h4>
            <p>{{ $item?->comment }}</p>
            <div class="comment-count">
                <i class="fa-solid fa-calendar-days"></i>
                {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('h:i A') : '' }}
            </div>
        </div>
    </div>
@endforeach
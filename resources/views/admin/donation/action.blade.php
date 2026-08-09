{{-- <div class='btn-group'>
   <a href="{{ route('admin.donation.show', $id) }}" class="btn btn-warning btn-xs" title="Invoice">
    <i class="fas fa-file-invoice"></i>
</a> --}}

 @if ($donation->donation_type === 'Donation_Monthly')
    <a href="{{ request()->is('admin*') ? route('admin.donation.subscription', $donation->id) : route('user.subscription', $donation->id) }}" class="btn btn-info btn-xs" title="Subscription Detail">
        <i class="fas fa-sync"></i>
    </a>
@endif 
</div>


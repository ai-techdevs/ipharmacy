<div class="subscription-card">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h3 class="mb-3"><i class="fas fa-gift me-2"></i>Monthly Donation (Square)</h3>
            <div class="mb-3">
                <span class="status-badge status-{{ strtolower($donation->subscription_status ?? 'pending') }}" id="subscription-status">
                    {{ ucfirst($donation->subscription_status ?? 'Pending') }}
                </span>
            </div>
            <p class="mb-2"><strong>Amount:</strong> ${{ number_format($donation->amount, 2) }}/month</p>
            <p class="mb-2"><strong>Next Payment:</strong>
                {{ $donation->next_payment_date ? \Carbon\Carbon::parse($donation->next_payment_date)->format('F j, Y') : 'N/A' }}
            </p>
            <p class="mb-0"><strong>Subscription ID:</strong> {{ $donation->transaction_id ?? 'N/A' }}</p>
        </div>
        <div class="col-md-4 text-end">
            <div class="btn-group">
                  <a href="{{ request()->is('admin*') ? route('admin.donation.index') : route('dashboard') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-1"></i> Return
</a>
                <button class="btn btn-success" onclick="refreshSquareStatus()">
                    <i class="fas fa-sync-alt me-1"></i> Refresh Status
                </button>
            </div>
        </div>
    </div>
</div>

<div class="text-center mb-4" id="action-buttons">
    <button class="action-btn btn-pause" id="pause-btn" onclick="pauseSquareSubscription()" @if($donation->subscription_status === 'paused' || $donation->subscription_status === 'cancelled') style="display:none;" @endif>
        <i class="fas fa-pause me-2"></i>Pause
    </button>

    <button class="action-btn btn-resume" id="resume-btn" onclick="resumeSquareSubscription()" @if($donation->subscription_status !== 'paused') style="display:none;" @endif>
        <i class="fas fa-play me-2"></i>Resume
    </button>

    <button class="action-btn btn-cancel" id="cancel-btn" onclick="cancelSquareSubscription()" @if($donation->subscription_status === 'cancelled') style="display:none;" @endif>
        <i class="fas fa-times me-2"></i>Cancel
    </button>
    <button class="action-btn btn-warning" id="cancel-scheduled-pause-btn" onclick="cancelScheduledPauseSubscription()" style="display:none;">
        <i class="fas fa-undo me-2"></i>Cancel Scheduled Pause
    </button>
</div>

<div class="loading" id="loading">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <p class="mt-2">Processing...</p>
</div>
<div class="subscription-details">
    <h4 class="mb-4"><i class="fas fa-info-circle me-2 text-primary"></i>Subscription Details</h4>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Subscriber:</strong> <span id="subscriber-name">{{ $donation->name }}</span></p>
            <p><strong>Email:</strong> <span id="subscriber-email">{{ $donation->email }}</span></p>
            <p><strong>Payment Method:</strong> <span id="payment-method">{{ ucfirst($donation->payment_method) }}</span></p>
        </div>
        <div class="col-md-6">
            <p><strong>Start Date:</strong> <span id="start-date">{{ \Carbon\Carbon::parse($donation->created_at)->format('F j, Y')  }}</span></p>
            <p><strong>Billing Cycle:</strong> Monthly</p>
            <p><strong>Currency:</strong> USD</p>
        </div>
    </div>
</div>
<script>
    const DONATION_ID = {{$donation->id}};
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const squareUrls = {
        pause: "{{ route('square.subscription.pause', ':id') }}".replace(':id', DONATION_ID)
        , resume: "{{ route('square.subscription.resume', ':id') }}".replace(':id', DONATION_ID)
        , cancel: "{{ route('square.subscription.cancel', ':id') }}".replace(':id', DONATION_ID)
        , status: "{{ route('square.subscription.status', ':id') }}".replace(':id', DONATION_ID)
        , cancelScheduledPause: "{{ route('square.subscription.cancel-scheduled-pause', ':id') }}".replace(':id', DONATION_ID)
    , };

    async function makeSquareRequest(url, method = 'POST') {
        showLoading();
        try {
            const res = await fetch(url, {
                method
                , headers: {
                    'Content-Type': 'application/json'
                    , 'X-CSRF-TOKEN': CSRF_TOKEN
                    , 'Accept': 'application/json'
                , }
            , });

            const result = await res.json();

            if (result.success) {
                alert(result.message);

                // If should_refresh flag is set, wait and refresh from Square
                if (result.should_refresh) {
                    console.log('Waiting 2 seconds before refreshing status from Square...');
                    setTimeout(() => {
                        refreshSquareStatus();
                    }, 2000);
                } else {
                    // Otherwise reload as normal
                    setTimeout(() => location.reload(), 1000);
                }
            } else {
                hideLoading();

                // Check for specific error scenarios
                if (result.message && result.message.includes('pending pause')) {
                    if (confirm(result.message + '\n\nWould you like to cancel the scheduled pause first?')) {
                        makeSquareRequest(squareUrls.cancelScheduledPause, 'POST');
                    }
                } else {
                    alert('Error: ' + (result.message || 'Operation failed'));
                }
            }
        } catch (err) {
            hideLoading();
            console.error('Error:', err);
            alert('Network error: ' + err.message);
        }
    }

    function pauseSquareSubscription() {
        if (confirm('Pause subscription from tomorrow?')) {
            makeSquareRequest(squareUrls.pause, 'POST');
        }
    }

    function resumeSquareSubscription() {
        if (confirm('Resume subscription?')) {
            makeSquareRequest(squareUrls.resume, 'POST');
        }
    }

    function cancelSquareSubscription() {
        if (confirm('Cancel subscription permanently?')) {
            makeSquareRequest(squareUrls.cancel, 'POST');
        }
    }

    function cancelScheduledPauseSubscription() {
        if (confirm('Cancel the scheduled pause? The subscription will remain active.')) {
            makeSquareRequest(squareUrls.cancelScheduledPause, 'POST');
        }
    }

    function refreshSquareStatus() {
        showLoading();
        makeSquareRequest(squareUrls.status, 'GET').then(() => {
            // After refresh, reload page to show updated status
            setTimeout(() => location.reload(), 500);
        });
    }

    function showLoading() {
        const loader = document.getElementById('loading');
        if (loader) loader.style.display = 'block';
    }

    function hideLoading() {
        const loader = document.getElementById('loading');
        if (loader) loader.style.display = 'none';
    }

</script>

   <div class="subscription-card">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-3"><i class="fas fa-heart me-2"></i>Monthly Donation</h3>
                            <div class="mb-3">
                                <span class="status-badge status-{{ strtolower($donation->subscription->status ?? 'pending') }}" id="subscription-status">
                                    {{ ucfirst($donation->subscription?->status ?? 'Pending') }}
                                </span>
                            </div>
                            <p class="mb-2"><strong>Amount:</strong> $<span id="donation-amount">{{ number_format($donation->amount, 2) }}</span>/month</p>
                            <p class="mb-2"><strong>Next Payment:</strong> <span id="next-payment">{{ $donation->subscription->next_payment_date ? \Carbon\Carbon::parse($donation->subscription->next_payment_date)->format('Y-m-d') : 'N/A' }}</span></p>
                            <p class="mb-0"><strong>Subscription ID:</strong> <span id="subscription-id">{{ $donation->subscription?->subscription_gateway_id ?? 'N/A' }}</span></p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="btn-group" role="group">
                             <a href="{{ request()->is('admin*') ? route('admin.donation.index') : route('dashboard') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-1"></i> Return
</a>
                                <button class="btn btn-success" onclick="refreshStatus()">
                                    <i class="fas fa-sync-alt me-1"></i> Refresh Status
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mb-4" id="action-buttons">
                    <button class="action-btn btn-pause" id="pause-btn" onclick="pauseSubscription()" @if(strtolower($donation->subscription->status ?? '') == 'suspended' || strtolower($donation->subscription->status ?? '') == 'cancelled') style="display:none;" @endif>
                        <i class="fas fa-pause me-2"></i>Pause Subscription
                    </button>

                    <button class="action-btn btn-resume" id="resume-btn" onclick="resumeSubscription()" @if(strtolower($donation->subscription->status ?? '') != 'suspended') style="display:none;" @endif>
                        <i class="fas fa-play me-2"></i>Resume Subscription
                    </button>

                    <button class="action-btn btn-cancel" id="cancel-btn" onclick="cancelSubscription()" @if(in_array(strtolower($donation->subscription->status ?? ''), ['cancelled', 'expired'])) style="display:none;" @endif>
                        <i class="fas fa-times me-2"></i>Cancel Subscription
                    </button>
                </div>

                <!-- Loading Indicator -->
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
                            <p><strong>Start Date:</strong> <span id="start-date">{{ $donation->subscription ? \Carbon\Carbon::parse($donation->subscription->start_date)->format('F j, Y') : 'N/A' }}</span></p>
                            <p><strong>Billing Cycle:</strong> Monthly</p>
                            <p><strong>Currency:</strong> USD</p>
                        </div>
                    </div>
                </div>



            

                <script>
                    const DONATION_ID = {{$donation->id}};
                    const subscriptionId = '{{ $donation->subscription?->subscription_gateway_id ?? '
                    ' }}';
                    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    const cancelUrl = "{{ route('subscription.cancel', ':id') }}".replace(':id', DONATION_ID);
                    const pauseUrl = "{{ route('subscription.pause', ':id') }}".replace(':id', DONATION_ID);
                    const resumeUrl = "{{ route('subscription.resume', ':id') }}".replace(':id', DONATION_ID);
                    const statusUrl = "{{ route('subscription.status', ':id') }}".replace(':id', DONATION_ID);

                    // Utility functions
                    function showLoading() {
                        const loader = document.getElementById('loading');
                        if (loader) loader.style.display = 'block';
                    }

                    function hideLoading() {
                        const loader = document.getElementById('loading');
                        if (loader) loader.style.display = 'none';
                    }

                    function showAlert(message, type = 'success') {
                        const alertContainer = document.getElementById('alert-container');
                        if (!alertContainer) return;
                        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                        alertContainer.innerHTML = `
            <div class="alert ${alertClass} alert-custom alert-dismissible fade show" role="alert">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
                    }

                    async function makeRequest(url, method = 'PUT') {
                        showLoading();
                        try {
                            const res = await fetch(url, {
                                method
                                , headers: {
                                    'Content-Type': 'application/json'
                                    , 'X-CSRF-TOKEN': CSRF_TOKEN
                                    , 'Accept': 'application/json'
                                }
                            });
                            const result = await res.json();
                            hideLoading();

                            if (result.success) {
                                showAlert(result.message, 'success');

                                // reload page after 1 second to reflect updated status
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);

                            } else {
                                showAlert(result.message || 'Operation failed', 'error');
                            }
                        } catch (err) {
                            hideLoading();
                            showAlert('Network error: ' + err.message, 'error');
                        }
                    }

                    function cancelSubscription() {
                        if (confirm('Cancel subscription?')) makeRequest(cancelUrl);
                    }

                    function pauseSubscription() {
                        if (confirm('Pause subscription?')) makeRequest(pauseUrl);
                    }

                    function resumeSubscription() {
                        if (confirm('Resume subscription?')) makeRequest(resumeUrl);
                    }

                    async function refreshStatus() {
                        makeRequest(statusUrl, 'GET');
                    }

                </script>
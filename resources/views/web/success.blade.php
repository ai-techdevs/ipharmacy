<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Successful - Thank You!</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .success-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 50px 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .success-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #4CAF50, #45a049);
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #4CAF50, #45a049);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .success-icon i { color: white; font-size: 35px; }
        .success-title { color: #2d3748; font-size: 2.2rem; font-weight: 700; margin-bottom: 15px; }
        .success-message { color: #718096; font-size: 1.1rem; margin-bottom: 30px; line-height: 1.6; }

        .donation-details {
            background: #f8fafc;
            border-radius: 15px;
            padding: 25px;
            margin: 30px 0;
            border-left: 4px solid #4CAF50;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 1rem;
        }
        .detail-row:last-child { margin-bottom: 0; }
        .detail-label { font-weight: 600; color: #4a5568; }
        .detail-value { color: #2d3748; font-weight: 500; }
        .amount-highlight { font-size: 1.3rem; color: #4CAF50; font-weight: 700; }

        .btn-home {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        .btn-home:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4); color: white; }

    </style>
</head>
<body>
<div class="success-container">
    <div class="success-card">
        <div class="success-icon"><i class="fas fa-check"></i></div>
        <h1 class="success-title">Thank You!</h1>
        <p class="success-message">Your donation has been processed successfully. Your generosity makes a real difference!</p>

        @if($donation)
            <div class="donation-details">
                @if($donation instanceof \App\Models\Donation)
                    {{-- ✅ SQUARE DONATION (Eloquent Model) --}}
                    @php 
                        $squareResponse = json_decode($donation->payment_response, true);
                    @endphp

                    <div class="detail-row">
                        <span class="detail-label">Payment Method:</span>
                        <span class="detail-value">Square</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Donation Amount:</span>
                        <span class="detail-value amount-highlight">${{ number_format($donation->amount, 2) }}</span>
                    </div>

                    @if($donation->subscription_id)
                        {{-- Monthly Subscription --}}
                        <div class="detail-row">
                            <span class="detail-label">Payment Type:</span>
                            <span class="detail-value">Recurring Monthly</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Subscription ID:</span>
                            <span class="detail-value">{{ $donation->subscription_id }}</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Status:</span>
                            <span class="detail-value">
                                <span class="badge bg-success">{{ ucfirst($donation->subscription_status ?? 'Active') }}</span>
                            </span>
                        </div>

                        @if($donation->next_payment_date)
                            <div class="detail-row">
                                <span class="detail-label">Next Payment:</span>
                                <span class="detail-value">{{ \Carbon\Carbon::parse($donation->next_payment_date)->format('M d, Y') }}</span>
                            </div>
                        @endif
                    @else
                        {{-- One-time Payment --}}
                        <div class="detail-row">
                            <span class="detail-label">Payment Type:</span>
                            <span class="detail-value">One-time</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Transaction ID:</span>
                            <span class="detail-value">{{ $donation->transaction_id ?? 'N/A' }}</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Status:</span>
                            <span class="detail-value">
                                <span class="badge bg-success">{{ ucfirst($donation->payment_status) }}</span>
                            </span>
                        </div>
                    @endif

                    <div class="detail-row">
                        <span class="detail-label">Donor:</span>
                        <span class="detail-value">{{ $donation->name }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">{{ $donation->email }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Date:</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($donation->created_at)->format('M d, Y h:i A') }}</span>
                    </div>

                @else
                    {{-- ✅ PAYPAL DONATION (Array) --}}
                    @if(isset($donation['purchase_units']))
                        {{-- One-time PayPal Payment --}}
                        @php
                            $capture = $donation['purchase_units'][0]['payments']['captures'][0];
                            $payer = $donation['payer'];
                        @endphp

                        <div class="detail-row">
                            <span class="detail-label">Payment Method:</span>
                            <span class="detail-value">PayPal</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Donation Amount:</span>
                            <span class="detail-value amount-highlight">
                                ${{ number_format($capture['amount']['value'], 2) }}
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Transaction ID:</span>
                            <span class="detail-value">{{ $capture['id'] }}</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Status:</span>
                            <span class="detail-value">
                                <span class="badge bg-success">{{ ucfirst(strtolower($capture['status'])) }}</span>
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Date:</span>
                            <span class="detail-value">
                                {{ \Carbon\Carbon::parse($capture['create_time'])->format('M d, Y h:i A') }}
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Donor:</span>
                            <span class="detail-value">
                                {{ $payer['name']['given_name'] ?? '' }} {{ $payer['name']['surname'] ?? '' }}
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Email:</span>
                            <span class="detail-value">{{ $payer['email_address'] ?? '' }}</span>
                        </div>

                    @elseif(isset($donation['subscriber']))
                        {{-- PayPal Subscription --}}
                        @php
                            $payer = $donation['subscriber'] ?? [];
                        @endphp

                        <div class="detail-row">
                            <span class="detail-label">Payment Method:</span>
                            <span class="detail-value">PayPal</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Payment Type:</span>
                            <span class="detail-value">Recurring Monthly</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Subscription ID:</span>
                            <span class="detail-value">{{ $donation['id'] ?? '' }}</span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Status:</span>
                            <span class="detail-value">
                                <span class="badge bg-success">{{ ucfirst(strtolower($donation['status'] ?? '')) }}</span>
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Start Date:</span>
                            <span class="detail-value">
                                {{ \Carbon\Carbon::parse($donation['start_time'])->format('M d, Y h:i A') }}
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Donor:</span>
                            <span class="detail-value">
                                {{ $payer['name']['given_name'] ?? '' }} {{ $payer['name']['surname'] ?? '' }}
                            </span>
                        </div>

                        <div class="detail-row">
                            <span class="detail-label">Email:</span>
                            <span class="detail-value">{{ $payer['email_address'] ?? '' }}</span>
                        </div>

                    @else
                        <p>No donation data available.</p>
                    @endif

                @endif
            </div>
        @endif

        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn-home"><i class="fas fa-home"></i> Return to Home</a>
        </div>
    </div>
</div>

<script>
    // Confetti effect
    function createConfetti() {
        const colors = ['#4CAF50', '#45a049', '#667eea', '#764ba2'];
        for (let i = 0; i < 50; i++) {
            setTimeout(() => {
                const confetti = document.createElement('div');
                confetti.style.position = 'fixed';
                confetti.style.left = Math.random() * window.innerWidth + 'px';
                confetti.style.top = '-10px';
                confetti.style.width = '6px';
                confetti.style.height = '6px';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.borderRadius = '50%';
                confetti.style.pointerEvents = 'none';
                confetti.style.zIndex = '9999';
                confetti.style.animation = 'fall 3s linear forwards';
                document.body.appendChild(confetti);
                setTimeout(() => confetti.remove(), 3000);
            }, i * 100);
        }
    }

    const style = document.createElement('style');
    style.textContent = `
        @keyframes fall {
            to {
                transform: translateY(${window.innerHeight + 20}px);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    // Trigger confetti on page load
    window.addEventListener('load', createConfetti);
</script>
</body>
</html>
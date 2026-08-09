<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f87171 0%, #c53030 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .failed-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .failed-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 50px 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        .failed-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #e53e3e, #c53030);
        }
        .failed-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #e53e3e, #c53030);
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
        .failed-icon i {
            color: white;
            font-size: 35px;
        }
        .failed-title {
            color: #e53e3e;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .failed-message {
            color: #718096;
            font-size: 1.1rem;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .donation-details {
            background: #f8fafc;
            border-radius: 15px;
            padding: 25px;
            margin: 30px 0;
            border-left: 4px solid #e53e3e;
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
        .amount-highlight { font-size: 1.3rem; color: #e53e3e; font-weight: 700; }
        .btn-home {
            background: linear-gradient(135deg, #f87171 0%, #c53030 100%);
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
            box-shadow: 0 4px 15px rgba(229, 62, 62, 0.3);
        }
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(229, 62, 62, 0.4);
            color: white;
        }
    </style>
</head>
<body>
    <div class="failed-container">
        <div class="failed-card">
            <div class="failed-icon">
                <i class="fas fa-times"></i>
            </div>

            <h1 class="failed-title">Payment Failed</h1>
            <p class="failed-message">
                Your transaction could not be completed. Please try again or contact support.
            </p>

            @if($donation)
            {{-- @php
                dd($donation);
            @endphp --}}
           
            <div class="donation-details">
                <div class="detail-row">
                    <span class="detail-label">Donation Amount:</span>
                    <span class="detail-value amount-highlight">${{ number_format($donation->amount, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Transaction ID:</span>
                    <span class="detail-value">{{ substr($donation->transaction_id, -8) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">{{ $donation->created_at->format('M d, Y H:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">
                        <span class="badge bg-danger">{{ ucfirst($donation->payment_status) }}</span>
                    </span>
                </div>
                @if($donation->name)
                <div class="detail-row">
                    <span class="detail-label">Donor:</span>
                    <span class="detail-value">{{ $donation->name }}</span>
                </div>
                @endif
            </div>
            @endif

            <div class="mt-4">
                <a href="{{ url('/') }}" class="btn-home">
                    <i class="fas fa-home"></i> Return to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>

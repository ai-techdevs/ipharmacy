<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Management</title>
    <link rel="icon" type="image/x-icon" href="{{ url('assets/images/favicon.jpg')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .subscription-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background: #28a745;
        }

        .status-suspended {
            background: #ffc107;
            color: #000;
        }

        .status-cancelled {
            background: #dc3545;
        }

        .status-pending {
            background: #6c757d;
        }

        .action-btn {
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            transition: all 0.3s ease;
            margin: 5px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .action-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-cancel {
            background: #dc3545;
            color: white;
        }

        .btn-pause {
            background: #ffc107;
            color: #000;
        }

        .btn-resume {
            background: #28a745;
            color: white;
        }

        .btn-refresh {
            background: #17a2b8;
            color: white;
        }

        .subscription-details {
            background: white;
            border-radius: 10px;
            padding: 25px;
            color: #333;
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .alert-custom {
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
        }

    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="text-center mb-5">
                                <h1 class="display-4 fw-bold text-primary mb-3">Subscription Management</h1>
                                <p class="lead text-muted">Manage your monthly donation subscription</p>
                            </div>

                            @if(strtolower($donation->payment_method) === 'paypal')
                            {{-- ✅ PayPal Subscription Section --}}
                            @include('admin.subscription.paypal', ['donation' => $donation])
                            @elseif(strtolower($donation->payment_method) === 'square')
                            {{-- 🟦 Square Subscription Section --}}
                            @include('admin.subscription.square', ['donation' => $donation])
                            @else
                            <div class="alert alert-warning text-center">
                                Unsupported payment method: {{ ucfirst($donation->payment_method) }}
                            </div>
                            @endif

                        </div>
                    </div>
                </div>







    {{-- <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold text-primary mb-3">Subscription Management</h1>
                    <p class="lead text-muted">Manage your monthly donation subscription</p>
                </div> --}}

                <!-- Alert Container -->
                {{-- <div id="alert-container"></div> --}}

                <!-- Subscription Card -->
             
            {{-- </div>
        </div>
    </div> --}}
</body>
</html>

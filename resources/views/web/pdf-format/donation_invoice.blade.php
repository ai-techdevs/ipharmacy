<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Donation Invoice</title>
    <style>
        body { font-family: sans-serif; }
        .invoice-box { max-width: 700px; margin: auto; padding: 20px; border: 1px solid #eee; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table td { padding: 8px; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h2>Donation Invoice</h2>
        <p><strong>Donor Name:</strong> {{ $donation->name }}</p>
        <p><strong>Email:</strong> {{ $donation->email }}</p>
        <p><strong>Phone:</strong> {{ $donation->phone }}</p>

        <table>
            <tr>
                <td><strong>Amount</strong></td>
                <td>{{ $donation->currency }} {{ number_format($donation->amount, 2) }}</td>
            </tr>
            <tr>
                <td><strong>Donation Type</strong></td>
                <td>{{ ucfirst(str_replace('_',' ',$donation->donation_type)) }}</td>
            </tr>
            <tr>
                <td><strong>Payment Method</strong></td>
                <td>{{ ucfirst($donation->payment_method) }}</td>
            </tr>
            <tr>
                <td><strong>Payment Status</strong></td>
                <td>{{ ucfirst($donation->payment_status) }}</td>
            </tr>
            <tr>
                <td><strong>Transaction ID</strong></td>
                <td>{{ $donation->transaction_id ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Date</strong></td>
                <td>{{ $donation->created_at->format('jS F, Y h:i A') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
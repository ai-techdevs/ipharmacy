
<!doctype html>
<html>
<head><meta charset="utf-8"></head>
<body>
    <p>Hi,</p>
    <p>Thank you for your generous donation of <strong>{{ $donation->currency }} {{ number_format($donation->amount, 2) }}</strong>.</p>
<p>Your invoice has been attached to this email.</p><br>


<p>Regards,<br>Our Organization</p>
</body>
</html>
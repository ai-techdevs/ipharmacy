<!DOCTYPE html>
<html>
<head>
    <title>{{ $coupon->title }}</title>
    <style>
        body { font-family: sans-serif; }
        .coupon { border: 2px dashed #333; padding: 20px; width: 500px; margin: 0 auto; }
        .offer { font-size: 24px; font-weight: bold; color: red; }
        .title { font-size: 20px; margin-top: 10px; }
        .description { margin-top: 10px; }
    </style>
</head>
<body>
    <div class="coupon">
        <div class="offer">{{ $coupon->discount }}</div>
        <div class="title">{{ $coupon->title }}</div>
        <div class="description">{{ $coupon->description }}</div>
        @if($coupon->image)
           <img src="file://{{ public_path('storage/' . $coupon->image) }}" alt="Coupon Image" style="width:200px; margin-top:10px;">
        @endif
    </div>
</body>
</html>

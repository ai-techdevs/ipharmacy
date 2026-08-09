@extends('web/layouts/master')

@section('content')
<div class="container">
    <h3>Complete Your Donation</h3>
    <p>Amount: ${{ $amount }}</p>

    <form id="square-payment-form" action="{{ route('square.process') }}" method="POST">
        @csrf

        {{-- Hidden donor details --}}
        <input type="hidden" name="amount" value="{{ $amount }}">
        <input type="hidden" name="type" value="{{ $type }}">
        <input type="hidden" name="name" value="{{ $name }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="phone" value="{{ $phone }}">
        <input type="hidden" name="nonce" id="card-nonce">

        <div id="card-container"></div>
        <button id="card-button" type="button" class="btn btn-primary">Pay with Card</button>
    </form>
</div>

<script type="text/javascript" src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
<script>
    const payments = Square.payments("{{ config('services.square.app_id') }}", "{{ config('services.square.location_id') }}");

    async function main() {
        const card = await payments.card();
        await card.attach('#card-container');

        document.getElementById('card-button').addEventListener('click', async function (event) {
            event.preventDefault();
            const result = await card.tokenize();
            if (result.status === 'OK') {
                document.getElementById('card-nonce').value = result.token;
                document.getElementById('square-payment-form').submit();
            } else {
                alert('Card error: ' + result.errors[0].message);
            }
        });
    }
    main();
</script>
@endsection

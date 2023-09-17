@extends('layouts.admin')

@section('content')
    <h1 class="title is-size-3-desktop is-size-4-tablet is-size-5-mobile">
        Checkout
    </h1>

    <div class="field">
        <label class="label">Cardholder Name</label>
        <div class="control">
            <input class="input" id="card-holder-name" type="text">
        </div>
    </div>

    <div class="field">
        <label class="label">Amount</label>
        <div class="control">
            <input class="input" name="amount" value="10" type="text" disabled>
        </div>
    </div>

    <!-- Stripe Elements Placeholder -->
    <script async
    src="https://js.stripe.com/v3/buy-button.js">
  </script>
  
  <stripe-buy-button
    buy-button-id="buy_btn_1NqsRQD6gIHtzX42MfdzG6jK"
    publishable-key="pk_live_51NqlAND6gIHtzX421BR8p8msHtsTr7m3R7VgJky3hqnsZb6j0UScTR0nW6bmOYniGY0FaC9ccWVVYC64t3WYNqCW00NZHnBiDe"
  >
  </stripe-buy-button>


@endsection


@section('scripts')
    <script src="{{ webpack('checkout', 'js') }}"></script>


    <script></script>
@endsection

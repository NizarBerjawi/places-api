<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Laravel\Cashier\Checkout;
use Stripe\Checkout\Session;
use Stripe\Price;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        // We make sure the user doesn't already have a subscription
        if ($request->user()->subscribed('default')) {
            return $request->user()->redirectToBillingPortal(route('admin.tokens.index'));
        }

        if (! $request->has('productId') || ! $request->has('priceId')) {
            abort(404);
        }

        $price = $request->user()->stripe()->prices->retrieve($request->get('priceId'));

        $checkout = Checkout::create($request->user(), [
            'line_items' => [[
                'price' => $request->get('priceId'),
                'quantity' => 1,
            ]],
            'mode' => $price->type === Price::TYPE_ONE_TIME
                ? 'payment'
                : 'subscription',
            'success_url' => route('admin.stripe.subscribe').'?sessionId={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('admin.tokens.index'),
            'metadata' => [
                'userId' => $request->user()->id,
                'productId' => $request->get('productId'),
            ],
        ] + ($price->type === Price::TYPE_RECURRING ? [
            'payment_method_collection' => 'if_required',
        ] : []));

        return $checkout->redirect();
    }

    public function subscribe(Request $request)
    {
        if (! $request->has('sessionId')) {
            throw new UnauthorizedException();
        }

        $session = $request->user()
            ->stripe()
            ->checkout
            ->sessions
            ->retrieve($request->get('sessionId'), [
                'expand' => ['subscription.default_payment_method'],
            ]);

        if (! in_array($session->payment_status, [
            Session::PAYMENT_STATUS_PAID,
            Session::PAYMENT_STATUS_NO_PAYMENT_REQUIRED,
        ])) {
            return redirect()->route('admin.stripe.plans');
        }

        return redirect()->route('admin.tokens.create');
    }

    public function billing(Request $request)
    {
        return $request->user()->redirectToBillingPortal(route('admin.tokens.index'));
    }

    public function plans(Request $request)
    {
        $products = $request->user()->stripe()
            ->products
            ->all([
                'active' => true,
                'expand' => ['data.default_price'],
            ]);

        return view('admin.plans')->with([
            'products' => collect($products)->reverse()->chunk(5)->toArray(),
        ]);
    }
}

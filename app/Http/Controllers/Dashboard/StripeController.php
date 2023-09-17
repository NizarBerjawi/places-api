<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public $stripe;

    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }

    public function checkout(Request $request, $uuid)
    {
        $token = PersonalAccessToken::withoutGlobalScope(PaidTokenScope::class)
            ->where('uuid', $uuid)
            ->first();

        if (! $request->has('sessionId')) {
            return view('admin.tokens.show', ['token' => $token]);
        }

        if (! $token) {
            return redirect()->route('admin.tokens.index');
        }

        if (! $request->user()->is($token->tokenable)) {
            throw new UnauthorizedException();
        }

        $session = $this
            ->stripe
            ->checkout
            ->sessions
            ->retrieve($request->get('sessionId'));

        if (! in_array($session->payment_status, [
            Session::PAYMENT_STATUS_PAID,
            Session::PAYMENT_STATUS_NO_PAYMENT_REQUIRED,
        ])) {
            throw new UnauthorizedException();
        }

        // We regenerate and activate the token
        $newAccessToken = $token->pay();
        $textToken = $newAccessToken->plainTextToken;

        if (strpos($textToken, '|') !== false) {
            [$uuid, $textToken] = explode('|', $textToken, 2);
        }

        return redirect()
            ->route('admin.tokens.show', $uuid)
            ->with('textToken', $textToken ?? null);
    }
}

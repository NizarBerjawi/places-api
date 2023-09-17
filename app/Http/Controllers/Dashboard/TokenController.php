<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TokenConfirmRequest;
use App\Http\Requests\TokenPostRequest;
use App\Http\Requests\TokenPutRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TokenController extends Controller
{
    public $stripe;

    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }

    public function index(Request $request)
    {
        return view('admin.tokens.index', [
            'tokens' => $request->user()->tokens()->simplePaginate(3),
        ]);
    }

    public function show(Request $request, $uuid)
    {
        $token = $request
            ->user()
            ->tokens()
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('admin.tokens.show', [
            'token' => $token,
        ]);
    }

    public function edit(Request $request, $uuid)
    {
        $token = $request
            ->user()
            ->tokens()
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view('admin.tokens.edit', [
            'token' => $token,
        ]);
    }

    public function update(TokenPutRequest $request, $uuid)
    {
        $token = $request
            ->user()
            ->tokens()
            ->where('uuid', $uuid)
            ->firstOrFail();

        $action = $request->get('action');

        if ($action === 'regenerate') {
            $newAccessToken = $token->regenerate();

            $textToken = $newAccessToken->plainTextToken;

            if (strpos($textToken, '|') !== false) {
                [$uuid, $textToken] = explode('|', $textToken, 2);
            }
        }

        if ($action === 'update') {
            $token->update([
                'name' => $request->input('token_name'),
            ]);
        }

        return redirect()
            ->route('admin.tokens.show', $uuid)
            ->with('textToken', $textToken ?? null);
    }

    public function create(Request $request)
    {
        $products = $this
            ->stripe
            ->products
            ->all(['expand' => ['data.default_price']]);

        return view('admin.tokens.create', ['products' => $products->data]);
    }

    public function store(TokenPostRequest $request)
    {
        $product = $this
            ->stripe
            ->products
            ->retrieve($request->product_id, [
                'expand' => ['default_price'],
            ]);

        $expiresAt = Carbon::now()->add('days', (int) $product->metadata->expiry)->endOfDay();

        // We create an inactive Token because payment is not complete.
        $token = $request->user()->createToken(
            $request->token_name,
            ['*'],
            $expiresAt
        );

        $link = $this
            ->stripe
            ->paymentLinks
            ->create([
                'line_items' => [
                    [
                        'price' => $product->default_price->id,
                        'quantity' => 1,
                    ],
                ],
                'after_completion' => [
                    'type' => 'redirect',
                    'redirect' => [
                        'url' => route('admin.stripe.checkout', [
                            'uuid' => $token->accessToken->uuid,
                        ]).'?sessionId={CHECKOUT_SESSION_ID}',
                    ],
                ],
                'metadata' => [
                    'userId' => $request->user()->id,
                    'tokenUuid' => $token->accessToken->uuid,
                ],
            ]);

        return redirect($link->url);
    }

    public function destroy(Request $request, $uuid)
    {
        $request->user()->tokens()->where('uuid', $uuid)->delete();

        return redirect()->route('admin.tokens.index');
    }

    public function confirm(TokenConfirmRequest $request, $uuid)
    {
        $action = $request->get('action');

        $token = $request->user()->tokens()->where('uuid', $uuid)->first();

        return view("admin.tokens.$action", compact('action', 'token'));
    }
}

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
    public function index(Request $request)
    {
        return view('admin.tokens.index', [
            'tokens' => $request
                ->user()
                ->tokens()
                ->orderBy('last_used_at')
                ->simplePaginate(5),
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
            $newAccessToken = $token->regenerate([
                'expires_at' => $request->input('expires_at'),
            ]);

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
        if ($request->user()->subscribed('default')) {
            return view('admin.tokens.create');
        }

        return redirect()->route('admin.stripe.plans');
    }

    public function store(TokenPostRequest $request)
    {
        $token = $request->user()
            ->createToken(
                $request->token_name,
                ['*'],
                Carbon::make($request->expires_at)
            );

        $textToken = $token->plainTextToken;

        if (strpos($textToken, '|') !== false) {
            [$uuid, $textToken] = explode('|', $textToken, 2);
        }

        return redirect()
            ->route('admin.tokens.show', $uuid)
            ->with('textToken', $textToken);
    }

    public function destroy(Request $request, $uuid)
    {
        $user = $request->user();

        $user->tokens()->where('uuid', $uuid)->delete();

        if ($user->hasWarning()) {
            $subscription = $user->subscription('default');

            $hasWarning = $user->tokens()->count() > $subscription->tokens_allowed;

            $request->user()->update(['account_warning' => $hasWarning]);
        }

        return redirect()->route('admin.tokens.index');
    }

    public function confirm(TokenConfirmRequest $request, $uuid)
    {
        $action = $request->get('action');

        $token = $request
            ->user()
            ->tokens()
            ->where('uuid', $uuid)
            ->firstOrFail();

        return view("admin.tokens.$action", compact('action', 'token'));
    }
}

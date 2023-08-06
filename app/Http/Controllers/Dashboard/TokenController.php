<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\UnauthorizedException;

class TokenController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.tokens.index', [
            'tokens' => $request->user()->tokens()->simplePaginate(3),
        ]);
    }

    public function show(Request $request, $id)
    {
        $token = $request->user()->tokens()->where('id', $id)->first();

        return view('admin.tokens.show', [
            'token' => $token,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $token = $request->user()->tokens()->where('id', $id)->first();

        return view('admin.tokens.edit', [
            'token' => $token,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'action' => ['required', Rule::in(['update', 'regenerate'])],
        ]);

        $token = $request->user()->tokens()->where('id', $id)->first();

        $action = $request->get('action');

        if ($action === 'regenerate') {
            $request->validate([
                'expires_at' => ['nullable', 'date', 'after_or_equal:tomorrow'],
            ]);

            $newAccessToken = $token->regenerateToken(
                Carbon::make($request->expires_at)
            );

            $textToken = $newAccessToken->plainTextToken;

            if (strpos($textToken, '|') !== false) {
                [$id, $textToken] = explode('|', $textToken, 2);
            }
        }

        if ($action === 'update') {
            $request->validate([
                'token_name' => [
                    'required',
                    Rule::unique('personal_access_tokens', 'name')->ignore($token),
                    'string',
                    'max:255',
                ],
            ]);

            $token->update(['name' => $request->input('token_name')]);
        }

        return redirect()->route('admin.tokens.show', $id)
            ->with('textToken', $textToken ?? null);
    }

    public function create(Request $request)
    {
        return view('admin.tokens.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'token_name' => [
                'required',
                'unique:personal_access_tokens,name',
                'string',
                'max:255',
            ],
            'expires_at' => ['nullable', 'date', 'after_or_equal:tomorrow'],
        ]);

        $token = $request->user()
            ->createToken(
                $request->token_name,
                ['*'],
                Carbon::make($request->expires_at)
            );

        $textToken = $token->plainTextToken;

        if (strpos($textToken, '|') !== false) {
            [$id, $textToken] = explode('|', $textToken, 2);
        }

        return redirect()->route('admin.tokens.show', $id)->with('textToken', $textToken);
    }

    public function destroy(Request $request, $id)
    {
        $request->user()->tokens()->where('id', $id)->delete();

        return redirect()->route('admin.tokens.index');
    }

    public function confirm(Request $request, $id)
    {
        $request->validate([
            'action' => ['required', Rule::in(['delete', 'regenerate'])],
        ]);

        if (! $request->has('action')) {
            throw new UnauthorizedException();
        }

        $action = $request->get('action');

        $token = $request->user()->tokens()->where('id', $id)->first();

        return view("admin.tokens.$action", compact('action', 'token'));
    }
}

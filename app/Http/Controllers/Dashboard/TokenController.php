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

    public function update(TokenPutRequest $request, $id)
    {
        $token = $request->user()->tokens()->where('id', $id)->first();

        $action = $request->get('action');

        if ($action === 'regenerate') {
            $newAccessToken = $token->regenerateToken(
                Carbon::make($request->expires_at)
            );

            $textToken = $newAccessToken->plainTextToken;

            if (strpos($textToken, '|') !== false) {
                [$id, $textToken] = explode('|', $textToken, 2);
            }
        }

        if ($action === 'update') {
            $token->update([
                'name' => $request->input('token_name'),
            ]);
        }

        return redirect()
            ->route('admin.tokens.show', $id)
            ->with('textToken', $textToken ?? null);
    }

    public function create(Request $request)
    {
        return view('admin.tokens.create');
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
            [$id, $textToken] = explode('|', $textToken, 2);
        }

        return redirect()->route('admin.tokens.show', $id)->with('textToken', $textToken);
    }

    public function destroy(Request $request, $id)
    {
        $request->user()->tokens()->where('id', $id)->delete();

        return redirect()->route('admin.tokens.index');
    }

    public function confirm(TokenConfirmRequest $request, $id)
    {
        $action = $request->get('action');

        $token = $request->user()->tokens()->where('id', $id)->first();

        return view("admin.tokens.$action", compact('action', 'token'));
    }
}

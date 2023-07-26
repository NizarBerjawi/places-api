<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.tokens-index', [
            'tokens' => $request->user()->tokens,
        ]);
    }

    public function show(Request $request, $id)
    {
        $token = $request->user()->tokens()->where('id', $id)->first();

        return view('admin.tokens-show', [
            'token' => $token,
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.tokens-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'token_name' => ['required', 'string', 'max:255'],
        ]);

        $token = $request->user()->createToken($request->token_name);

        $last = $request
            ->user()
            ->tokens()
            ->orderBy('created_at', 'desc')
            ->limit(1)
            ->first();

        $textToken = $token->plainTextToken;

        if (strpos($textToken, '|') !== false) {
            [$id, $textToken] = explode('|', $textToken, 2);
        }

        return redirect('admin.tokens.show', ['id' => $last->id])->with('textToken', $textToken);
    }
}

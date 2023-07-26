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
        $token = $request->user()->tokens()->where('id', $id)->first();

        return view('admin.tokens-delete', [
            'token' => $token,
        ]);
    }
}

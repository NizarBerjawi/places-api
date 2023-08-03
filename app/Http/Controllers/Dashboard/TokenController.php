<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

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
        if (!$request->has('action')) {
            return back();
        }

        $token = $request->user()->tokens()->where('id', $id)->first();

        $action = $request->get('action');

        if ($action === 'regenerate') {
            $newAccessToken = $token->regenerateToken();

            $textToken = $newAccessToken->plainTextToken;

            if (strpos($textToken, '|') !== false) {
                [$id, $textToken] = explode('|', $textToken, 2);
            }
        }

        if ($action === 'update') {
            $request->validate([
                'token_name' => ['required', 'string', 'max:255'],
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
        $request->validate([
            'action' => ['required', Rule::in(['delete', 'regenerate'])],
        ]);

        if (!$request->has('action')) {
            return back();
        }

        $action = $request->get('action');

        $token = $request->user()->tokens()->where('id', $id)->first();

        return view("admin.tokens.$action", [
            'token' => $token,
        ]);
    }
}

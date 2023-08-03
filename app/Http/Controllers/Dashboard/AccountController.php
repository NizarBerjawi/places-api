<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.account.index')->with('user', $request->user());
    }

    public function destroy(Request $request, $id)
    {
        if ($request->user()->id !== $id) {
            throw new UnauthorizedException();
        }

        $request->user()->delete();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\UnauthorizedException;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.account.index')->with('user', $request->user());
    }

    public function destroy(Request $request, int $id)
    {
        if ($request->user()->id !== $id) {
            throw new UnauthorizedException();
        }

        $request->user()->delete();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $request->session()->flash('success', 'Your account was deleted successfully');

        return redirect()->route('register');
    }

    public function confirm(Request $request, $id)
    {
        $request->validate([
            'action' => ['required', Rule::in(['delete'])],
        ]);

        if (! $request->has('action')) {
            return back();
        }

        $action = $request->get('action');

        return view("admin.account.$action")->with('user', $request->user());
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.security.index');
    }

    public function recovery(Request $request)
    {
        return view('admin.security.recovery-codes');
    }

    public function confirm(Request $request)
    {
        return view('admin.confirm-password')
            ->with('intended', $request->session()->get('url.intended'));
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function store()
    {
        dd('test');
    }
}

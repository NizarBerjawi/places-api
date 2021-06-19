<?php

namespace App\Http\Controllers;

class WebController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function docs()
    {
        return view('docs');
    }

    public function intro()
    {
        return view('intro');
    }
}

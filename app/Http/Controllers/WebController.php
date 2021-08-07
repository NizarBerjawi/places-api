<?php

namespace App\Http\Controllers;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

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

    public function flags($flag)
    {
        $filesystem = new Filesystem();

        $filepath = storage_path("app/flags/$flag");

        if ($filesystem->missing($filepath)) {
            abort(404);
        }

        return new BinaryFileResponse($filepath, 200);
    }
}

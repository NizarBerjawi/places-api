<?php

use App\Providers\RouteServiceProvider;

if (! function_exists('webpack')) {
    /**
     * Get path to a webpack bundle asset.
     *
     * @param  string  $bundle Bundle name
     * @param  string  $type Asset type to take from the bundle ('js' or 'css')
     * @return string Path to asset
     */
    function webpack($bundle, $type = 'js')
    {
        $filesystem = new \Illuminate\Filesystem\Filesystem();

        $path = public_path('dist/manifest.json');

        try {
            $manifest = json_decode($filesystem->get($path));
        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
            throw new \Illuminate\Contracts\Filesystem\FileNotFoundException(
                'Unable to locate webpack manifest'
            );
        }

        if (! isset($manifest->$bundle->$type)) {
            throw new InvalidArgumentException("Unable to find $bundle $type bundle");
        }

        return asset('dist/'.$manifest->$bundle->$type);
    }
}

if (! function_exists('home')) {
    /**
     * Get path to a webpack bundle asset.
     *
     * @return string Home route
     */
    function home()
    {
        return url(RouteServiceProvider::HOME);
    }
}

<?php

if (! function_exists('public_path')) {
    /**
     * Get the path to the application public folder.
     *
     * @param  string  $path
     * @return string
     */
    function public_path($path = '')
    {
        return app()->basePath('public'.($path ? DIRECTORY_SEPARATOR.$path : $path));
    }
}

if (! function_exists('dist_path')) {
    /**
     * Get the path to the application dist folder.
     *
     * @param  string  $path
     * @return string
     */
    function dist_path($path = '')
    {
        return public_path('dist'.($path ? DIRECTORY_SEPARATOR.$path : $path));
    }
}

if (! function_exists('asset_path')) {
    /**
     * Get the path to the application configuration files.
     *
     * @param  string  $path
     * @return string
     */
    function asset_path($path = '')
    {
        return DIRECTORY_SEPARATOR.'dist'.DIRECTORY_SEPARATOR.($path);
    }
}

if (! function_exists('webpack')) {
    /**
     * Get path to a webpack bundle asset.
     *
     * @param string $bundle Bundle name
     * @param string $type Asset type to take from the bundle ('js' or 'css')
     * @return string Path to asset
     */
    function webpack($bundle, $type = 'js')
    {
        $filesystem = new \Illuminate\Filesystem\Filesystem();

        $path = dist_path('manifest.json');

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

        return asset_path($manifest->$bundle->$type);
    }
}

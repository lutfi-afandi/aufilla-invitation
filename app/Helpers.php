<?php

use Illuminate\Support\Facades\App;

if (!function_exists('assetv')) {
    /**
     * Generate an asset URL with a cache-busting version query string.
     * Appends ?v={config('app.asset_version')} so replacing a file with the
     * same name forces browsers / CDN to fetch the new version.
     *
     * @param  string  $path
     * @param  bool|null  $secure
     * @return string
     */
    function assetv(string $path, ?bool $secure = null): string
    {
        $version = config('app.asset_version', '1');
        $separator = str_contains($path, '?') ? '&' : '?';

        return asset($path . $separator . 'v=' . $version, $secure);
    }
}

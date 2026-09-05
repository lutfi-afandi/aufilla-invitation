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

if (!function_exists('setting')) {
    /**
     * Get a setting value with an optional default.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return \App\Models\Setting::get($key, $default);
    }
}

if (!function_exists('setting_json')) {
    /**
     * Get a setting value decoded from JSON with an optional default array.
     *
     * @param  string  $key
     * @param  array  $default
     * @return array
     */
    function setting_json(string $key, array $default = []): array
    {
        return \App\Models\Setting::getJson($key, $default);
    }
}

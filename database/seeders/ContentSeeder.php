<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theme;
use App\Models\Package;

class ContentSeeder extends Seeder
{
    public function run()
    {
        $themesJson = file_get_contents(base_path('themes_utf8.json'));
        $themesJson = preg_replace('/^[\xef\xbb\xbf]+/', '', $themesJson);
        $themesJson = preg_replace('/^.*?(?=\[)/s', '', $themesJson);
        $themes = json_decode($themesJson, true);
        if ($themes) {
            foreach ($themes as $theme) {
                unset($theme['id']);
                Theme::create($theme);
            }
        }

        $packagesJson = file_get_contents(base_path('packages_utf8.json'));
        $packagesJson = preg_replace('/^[\xef\xbb\xbf]+/', '', $packagesJson);
        $packagesJson = preg_replace('/^.*?(?=\[)/s', '', $packagesJson);
        $packages = json_decode($packagesJson, true);
        if ($packages) {
            foreach ($packages as $pkg) {
                unset($pkg['id']);
                Package::create($pkg);
            }
        }
    }
}

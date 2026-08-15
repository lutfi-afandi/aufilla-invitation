<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tema;

class ContentSeeder extends Seeder
{
    public function run()
    {
        $themesPath = base_path('.agents/data/themes_utf8.json');
        if (file_exists($themesPath)) {
            $themesJson = file_get_contents($themesPath);
            $themesJson = preg_replace('/^[\xef\xbb\xbf]+/', '', $themesJson);
            $themesJson = preg_replace('/^.*?(?=\[)/s', '', $themesJson);
            $themes = json_decode($themesJson, true);
            if ($themes) {
                foreach ($themes as $theme) {
                    unset($theme['id']);
                    Tema::updateOrCreate(['code' => $theme['code']], $theme);
                }
            }
        }

        $this->call(PaketSeeder::class);
    }
}

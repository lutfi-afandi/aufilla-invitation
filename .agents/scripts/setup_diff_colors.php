<?php

$target = 'resources/views/themes/aufilla-diff/index.blade.php';

function hexToRgb($hex) {
    $hex = str_replace('#', '', $hex);
    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    return "$r, $g, $b";
}
function hexToRgbNoSpace($hex) {
    return str_replace(', ', ',', hexToRgb($hex));
}

// Aufilla Diff Pink configuration
$config = [
    'primary_800' => '#99005c', 
    'primary_900' => '#66003d', 
    'primary_950' => '#33001f', 
    'secondary'   => '#B76E79', // Rose Gold
    'pearl_100'   => '#FFF5F8', // Pinkish White
    'primary_palette' => "50: '#FFF0F7', 100: '#FFE0F0', 200: '#FFC2E2', 300: '#FFA3D3', 400: '#FF85C4', 500: '#FF80C7', 600: '#E6008A', 700: '#B3006B', 800: '#99005c', 900: '#66003d', 950: '#33001f'",
];

$content = file_get_contents($target);

// FIX 1: The giant horizontal stripe bug
$content = str_replace('inline-self-start', 'self-start inline-block', $content);

// FIX 2: Universal Dark Glass for transparent boxes
$content = str_replace('bg-[#5A1F24]/75', 'bg-black/40', $content);
$content = str_replace('bg-[#5A1F24]/80', 'bg-black/40', $content);

// FIX 3: Left gradient bottom to top clear
$oldLeftGradient = 'linear-gradient(135deg, rgba(61,21,24,0.92) 0%, rgba(90,31,36,0.85) 100%)';
$newLeftGradient = 'linear-gradient(to top, rgba(' . hexToRgbNoSpace($config['primary_950']) . ', 0.95) 0%, rgba(' . hexToRgbNoSpace($config['primary_900']) . ', 0.0) 100%)';
$content = str_replace($oldLeftGradient, $newLeftGradient, $content);

// FIX 4: Protect header text contrast
$content = str_replace('bg-black/10 backdrop-blur-xs p-4 rounded-lg', 'bg-black/50 backdrop-blur-md border border-white/10 shadow-2xl p-5 rounded-xl', $content);

// FIX 5: Navigation Fixes from fix_nav_all_themes.php
$content = str_replace('py-20 px-6 bg-[', 'pt-20 pb-32 px-6 bg-[', $content);
$content = str_replace("addClass('text-gold-400 font-bold scale-110');", "addClass('text-amber-300 font-bold drop-shadow-[0_0_5px_rgba(251,191,36,0.5)] scale-125');", $content);
$content = str_replace("removeClass('text-gold-400 font-bold scale-110')", "removeClass('text-amber-300 font-bold drop-shadow-[0_0_5px_rgba(251,191,36,0.5)] scale-125')", $content);
$content = str_replace('text-white hover:text-gold-400', 'text-stone-300 hover:text-amber-300', $content);
$content = str_replace('hover:text-gold-400', 'hover:text-amber-300', $content);

// Rename classes globally
$content = str_replace('maroon-', 'primary-', $content);
$content = str_replace('burgundy', 'secondary', $content);

// Replace hardcoded Hex colors
$content = str_replace('#5A1F24', $config['primary_800'], $content);
$content = str_replace('#3D1518', $config['primary_900'], $content);
$content = str_replace('#250B0D', $config['primary_950'], $content);
$content = str_replace('#6B2737', $config['secondary'], $content);
$content = str_replace('#F7F2EC', $config['pearl_100'], $content);

// Replace RGBA values
$content = str_replace('rgba(90, 31, 36', 'rgba(' . hexToRgb($config['primary_800']), $content);
$content = str_replace('rgba(61, 21, 24', 'rgba(' . hexToRgb($config['primary_900']), $content);
$content = str_replace('rgba(37, 11, 13', 'rgba(' . hexToRgb($config['primary_950']), $content);

$content = str_replace('rgba(90,31,36', 'rgba(' . hexToRgbNoSpace($config['primary_800']), $content);
$content = str_replace('rgba(61,21,24', 'rgba(' . hexToRgbNoSpace($config['primary_900']), $content);
$content = str_replace('rgba(37,11,13', 'rgba(' . hexToRgbNoSpace($config['primary_950']), $content);

// Inject the new tailwind configuration primary palette
$twConfig = "
      colors: {
        primary: {
          " . $config['primary_palette'] . "
        },
        secondary: '" . $config['secondary'] . "',";

$content = preg_replace('/colors: \{[\s\S]*?primary: \{[\s\S]*?\},[\s\n]*secondary: \'#6B2737\',/', $twConfig, $content);

file_put_contents($target, $content);

echo "Base colors for Aufilla Diff injected!\n";

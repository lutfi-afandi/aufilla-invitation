<?php
$font_urls = [
    'bunny-instrument' => 'https://fonts.bunny.net/css?family=instrument-sans:400,500,600',
    'bunny-inter-playfair' => 'https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:400,500,600,700i&display=swap',
    'bunny-figtree' => 'https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap',
    'bunny-inter-admin' => 'https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap',
    'google-playfair' => 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap',
    'google-theme' => 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&family=DM+Sans:wght@300;400;500;700&display=swap'
];

$fontDir = __DIR__ . '/public/assets/fonts';
$cssDir = __DIR__ . '/public/assets/css';

@mkdir($fontDir, 0777, true);
@mkdir($cssDir, 0777, true);

$options = [
    'http' => [
        'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36\r\n"
    ]
];
$context = stream_context_create($options);

foreach ($font_urls as $name => $url) {
    echo "Downloading CSS: $name\n";
    $css = file_get_contents($url, false, $context);
    
    if (!$css) {
        echo "  Failed to download CSS.\n";
        continue;
    }
    
    // find url(...)
    preg_match_all('/url\((https:\/\/[^\)]+)\)/i', $css, $matches);
    
    foreach ($matches[1] as $font_url) {
        $font_url = trim($font_url, "'\"");
        $filename = basename(parse_url($font_url, PHP_URL_PATH));
        // add prefix to avoid name collision
        $filename = substr(md5($font_url), 0, 8) . '_' . $filename;
        
        $local_path = $fontDir . '/' . $filename;
        if (!file_exists($local_path)) {
            echo "  Downloading font: $filename\n";
            $font_data = file_get_contents($font_url, false, $context);
            if ($font_data) {
                file_put_contents($local_path, $font_data);
            } else {
                echo "    FAILED.\n";
            }
        }
        
        // replace in CSS
        $css = str_replace($font_url, '../fonts/' . $filename, $css);
    }
    
    file_put_contents($cssDir . '/' . $name . '.css', $css);
    echo "Saved $name.css\n";
}

echo "All fonts downloaded.\n";

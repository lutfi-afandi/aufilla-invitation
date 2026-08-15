<?php

// Replaces all asset(...) calls with assetv(...) in every theme Blade file
// so image/asset URLs get the cache-busting ?v= query string.

$base = __DIR__ . '/resources/views/themes';
$count = 0;
$files = 0;

$rii = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS)
);

foreach ($rii as $file) {
    if (substr($file->getFilename(), -10) !== '.blade.php') {
        continue;
    }

    $path = $file->getPathname();
    $content = file_get_contents($path);

    // Only replace asset( that is NOT already assetv(
    $newContent = preg_replace('/assetv\(/', '__ASSETV_PLACEHOLDER__', $content);
    $newContent = preg_replace('/asset\(/', 'assetv(', $newContent);
    $newContent = str_replace('__ASSETV_PLACEHOLDER__', 'assetv(', $newContent);

    if ($newContent !== $content) {
        file_put_contents($path, $newContent);
        $files++;
        $count += substr_count($newContent, 'assetv(');
    }
}

echo "Done. Updated {$files} files, {$count} assetv() calls.\n";

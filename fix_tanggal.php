<?php
$files = [
    'c:\\laragon\\www\\self-project\\my-undangan-v2\\resources\\views\\themes\\aufilla-maroon\\index.blade.php',
    'c:\\laragon\\www\\self-project\\my-undangan-v2\\resources\\views\\themes\\aufilla-green\\index.blade.php',
    'c:\\laragon\\www\\self-project\\my-undangan-v2\\app\\Http\\Controllers\\PublicInvitationController.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $content = str_replace('$akad->tanggal', '$akad->tgl_acara', $content);
        $content = str_replace('$resepsi->tanggal', '$resepsi->tgl_acara', $content);
        
        // Also fix the preview mode
        $content = str_replace("'tanggal' => now()->addDays(14)->format('Y-m-d')", "'tgl_acara' => now()->addDays(14)->format('Y-m-d')", $content);
        
        file_put_contents($file, $content);
        echo "Fixed $file\n";
    }
}

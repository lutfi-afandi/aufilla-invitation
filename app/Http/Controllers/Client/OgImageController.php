<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class OgImageController extends Controller
{
    public function generate($id)
    {
        $invitation = Invitation::with('akad')->findOrFail($id);
        $ogPath = storage_path("app/public/og/og_invitation_{$id}.jpg");

        // Ensure directory exists
        try {
            if (!File::exists(dirname($ogPath))) {
                File::makeDirectory(dirname($ogPath), 0755, true);
            }
        } catch (\Exception $e) {
            // Jika Hostinger melarang pembuatan folder, return default
            return response()->file(public_path('assets/img/thumbnail-tema/demo1.png'));
        }

        // Cache logic
        if (File::exists($ogPath) && filemtime($ogPath) >= $invitation->updated_at->timestamp && !request()->has('refresh')) {
            return response()->file($ogPath);
        }

        // Jika tidak ada cover image, gunakan default thumbnail tema
        if (!$invitation->cover_img || !Storage::disk('public')->exists($invitation->cover_img)) {
            $defaultPath = $invitation->theme?->thumbnail ? storage_path('app/public/' . $invitation->theme->thumbnail) : public_path('assets/img/thumbnail-tema/demo1.png');
            if (File::exists($defaultPath)) {
                return response()->file($defaultPath);
            }
            return response()->file(public_path('assets/img/thumbnail-tema/demo1.png'));
        }

        $avatarPath = Storage::disk('public')->path($invitation->cover_img);
        $info = @getimagesize($avatarPath);
        if (!$info) {
            return response()->file(public_path('assets/img/thumbnail-tema/demo1.png'));
        }

        // Buka gambar asli
        switch ($info['mime']) {
            case 'image/jpeg': $src = @imagecreatefromjpeg($avatarPath); break;
            case 'image/png':  $src = @imagecreatefrompng($avatarPath); break;
            case 'image/webp': $src = @imagecreatefromwebp($avatarPath); break;
            default: return response()->file(public_path('assets/img/thumbnail-tema/demo1.png'));
        }

        if (!$src) {
            return response()->file(public_path('assets/img/thumbnail-tema/demo1.png'));
        }

        // Setup Canvas 800x600 (Ukuran aman WhatsApp)
        $targetW = 800;
        $targetH = 600;
        
        $srcW = imagesx($src);
        $srcH = imagesy($src);

        // Crop & Resize (Center Crop)
        $srcRatio = $srcW / $srcH;
        $targetRatio = $targetW / $targetH;

        if ($srcRatio > $targetRatio) {
            $cropW = (int) ($srcH * $targetRatio);
            $cropH = $srcH;
            $cropX = (int) (($srcW - $cropW) / 2);
            $cropY = 0;
        } else {
            $cropW = $srcW;
            $cropH = (int) ($srcW / $targetRatio);
            $cropX = 0;
            $cropY = (int) (($srcH - $cropH) / 2);
        }

        $image = imagecreatetruecolor($targetW, $targetH);
        
        // Background putih jika ada transparan
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);

        imagecopyresampled($image, $src, 0, 0, $cropX, $cropY, $targetW, $targetH, $cropW, $cropH);
        imagedestroy($src);

        // Save as JPEG dengan quality 70 (agar size dibawah 100KB untuk WhatsApp)
        try {
            imagejpeg($image, $ogPath, 70);
            imagedestroy($image);
            return response()->file($ogPath);
        } catch (\Exception $e) {
            // Jika gagal save (permission), langsung stream output
            ob_start();
            imagejpeg($image, null, 70);
            $imgData = ob_get_clean();
            imagedestroy($image);
            return response($imgData)->header('Content-Type', 'image/jpeg');
        }
    }

}

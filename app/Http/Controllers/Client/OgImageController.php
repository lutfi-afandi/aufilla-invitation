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

        // Setup Canvas 1200x630
        $width = 1200;
        $height = 630;
        $image = imagecreatetruecolor($width, $height);

        // Colors
        $bg = imagecolorallocate($image, 248, 250, 252); // slate-50 #F8FAFC
        $textDark = imagecolorallocate($image, 15, 23, 42); // slate-900 #0F172A
        $textMuted = imagecolorallocate($image, 100, 116, 139); // slate-500 #64748B
        $accentBlue = imagecolorallocate($image, 37, 99, 235); // blue-600 #2563EB
        $white = imagecolorallocate($image, 255, 255, 255);

        // Fill background
        imagefill($image, 0, 0, $bg);

        // Draw Accent Line (Left border ala GitHub PR)
        imagefilledrectangle($image, 0, 0, 16, $height, $accentBlue);

        // Fonts
        $fontBold = public_path('assets/fonts/Inter-Bold.ttf');
        $fontReg = public_path('assets/fonts/Inter-Regular.ttf');

        if (!File::exists($fontBold)) {
            // Fallback to default thumbnail to prevent 500 Error for WhatsApp Crawler
            return response()->file(public_path('assets/img/thumbnail-tema/demo1.png'));
        }

        // Draw Branding
        imagettftext($image, 14, 0, 80, 80, $accentBlue, $fontBold, "AUFILLA DIGITAL INVITATION");

        // Draw Subtitle
        imagettftext($image, 22, 0, 80, 180, $textMuted, $fontReg, "Pernikahan dari");

        // Draw Couple Names
        $names = $invitation->pria_nama . " & " . $invitation->wanita_nama;
        $fontSize = 80;
        $bbox = imagettfbbox($fontSize, 0, $fontBold, $names);
        $textWidth = $bbox[2] - $bbox[0];
        
        // Responsive font size
        while ($textWidth > 680 && $fontSize > 30) {
            $fontSize -= 2;
            $bbox = imagettfbbox($fontSize, 0, $fontBold, $names);
            $textWidth = $bbox[2] - $bbox[0];
        }
        
        imagettftext($image, $fontSize, 0, 76, 280, $textDark, $fontBold, $names);

        // Draw Date
        $dateText = $invitation->akad ? \Carbon\Carbon::parse($invitation->akad->tgl_acara)->translatedFormat('l, d F Y') : 'Waktu menyusul';
        imagettftext($image, 20, 0, 80, 380, $textDark, $fontBold, "Tanggal");
        imagettftext($image, 20, 0, 200, 380, $textMuted, $fontReg, $dateText);
        
        // Draw Location
        $locationText = $invitation->akad ? $invitation->akad->tempat_nama : 'Lokasi menyusul';
        if (strlen($locationText) > 40) $locationText = substr($locationText, 0, 40) . '...';
        imagettftext($image, 20, 0, 80, 430, $textDark, $fontBold, "Lokasi");
        imagettftext($image, 20, 0, 200, 430, $textMuted, $fontReg, $locationText);

        // URL at bottom
        $url = url('/' . $invitation->slug);
        imagettftext($image, 18, 0, 80, 560, $textMuted, $fontReg, $url);
        
        // Draw Avatar on the right
        $avatarSize = 340;
        $avatarX = 780;
        $avatarY = 145;

        // Draw soft shadow behind avatar (Circle)
        $shadowColor = imagecolorallocatealpha($image, 15, 23, 42, 110);
        imagefilledellipse($image, $avatarX + ($avatarSize/2), $avatarY + ($avatarSize/2) + 15, $avatarSize, $avatarSize, $shadowColor);

        if ($invitation->cover_img && Storage::disk('public')->exists($invitation->cover_img)) {
            $avatarPath = Storage::disk('public')->path($invitation->cover_img);
            $this->drawCircularAvatar($image, $avatarPath, $avatarX, $avatarY, $avatarSize);
        } else {
            // Placeholder circle
            $placeholderColor = imagecolorallocate($image, 226, 232, 240); // slate-200
            imagefilledellipse($image, $avatarX + ($avatarSize/2), $avatarY + ($avatarSize/2), $avatarSize, $avatarSize, $placeholderColor);
            
            $initials = strtoupper(substr($invitation->pria_nama, 0, 1) . substr($invitation->wanita_nama, 0, 1));
            $bbox = imagettfbbox(80, 0, $fontBold, $initials);
            $tw = $bbox[2] - $bbox[0];
            $th = $bbox[1] - $bbox[7];
            imagettftext($image, 80, 0, $avatarX + ($avatarSize/2) - ($tw/2) - 5, $avatarY + ($avatarSize/2) + ($th/2) - 5, $textMuted, $fontBold, $initials);
        }

        // Save as JPEG to keep file size small (WhatsApp limit ~300KB)
        try {
            imagejpeg($image, $ogPath, 80);
            imagedestroy($image);
            return response()->file($ogPath);
        } catch (\Exception $e) {
            // Jika gagal save (permission), langsung stream output
            ob_start();
            imagejpeg($image, null, 80);
            $imgData = ob_get_clean();
            imagedestroy($image);
            return response($imgData)->header('Content-Type', 'image/jpeg');
        }
    }

    private function drawCircularAvatar($canvas, $imagePath, $dstX, $dstY, $size)
    {
        $info = getimagesize($imagePath);
        if (!$info) return;

        switch ($info['mime']) {
            case 'image/jpeg': $src = imagecreatefromjpeg($imagePath); break;
            case 'image/png':  $src = imagecreatefrompng($imagePath); break;
            case 'image/webp': $src = imagecreatefromwebp($imagePath); break;
            default: return;
        }

        $srcW = imagesx($src);
        $srcH = imagesy($src);
        $minSize = min($srcW, $srcH);
        
        $tempCanvas = imagecreatetruecolor($size, $size);
        imagealphablending($tempCanvas, false);
        imagesavealpha($tempCanvas, true);
        $transparent = imagecolorallocatealpha($tempCanvas, 0, 0, 0, 127);
        imagefill($tempCanvas, 0, 0, $transparent);

        $square = imagecreatetruecolor($size, $size);
        imagecopyresampled($square, $src, 0, 0, ($srcW - $minSize) / 2, ($srcH - $minSize) / 2, $size, $size, $minSize, $minSize);

        $radius = $size / 2;
        for ($x = 0; $x < $size; $x++) {
            for ($y = 0; $y < $size; $y++) {
                $distance = sqrt(pow($x - $radius, 2) + pow($y - $radius, 2));
                if ($distance <= $radius) {
                    $color = imagecolorat($square, $x, $y);
                    if ($distance > $radius - 1) {
                        $alpha = (int) (127 * ($distance - ($radius - 1)));
                        $rgb = imagecolorsforindex($square, $color);
                        $color = imagecolorallocatealpha($tempCanvas, $rgb['red'], $rgb['green'], $rgb['blue'], $alpha);
                    }
                    imagesetpixel($tempCanvas, $x, $y, $color);
                }
            }
        }

        imagealphablending($canvas, true);
        imagecopy($canvas, $tempCanvas, $dstX, $dstY, 0, 0, $size, $size);

        imagedestroy($src);
        imagedestroy($square);
        imagedestroy($tempCanvas);
    }
}

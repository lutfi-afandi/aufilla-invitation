<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageHelper
{
    /**
     * Upload and compress an image file to WebP format.
     * Fallback safely to standard store() if GD compression fails, memory is exceeded, or format is unsupported (e.g., SVG).
     *
     * @param UploadedFile $file
     * @param string $folder Relative directory inside 'storage/app/public' (e.g. 'pengantin', 'galeri', 'themes/thumbnails', 'settings')
     * @param int $maxWidth Maximum width in pixels (default 1200)
     * @param int $quality WebP quality 1-100 (default 80)
     * @return string Relative path stored in public disk (e.g. 'pengantin/img_12345.webp')
     */
    public static function uploadAndCompress(UploadedFile $file, string $folder, int $maxWidth = 1200, int $quality = 80): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = strtolower($file->getMimeType() ?: '');

        // For SVG or ICO files, bypass GD and store directly
        if ($extension === 'svg' || str_contains($mime, 'svg') || $extension === 'ico') {
            return $file->store($folder, 'public');
        }

        try {
            $realPath = $file->getRealPath();
            if (!$realPath || !file_exists($realPath)) {
                return $file->store($folder, 'public');
            }

            // Inspect image dimensions without loading entire raw bitmap to RAM
            $info = @getimagesize($realPath);
            if (!$info) {
                return $file->store($folder, 'public');
            }

            $width = $info[0] ?? 0;
            $height = $info[1] ?? 0;
            $imageType = $info[2] ?? 0;

            if ($width <= 0 || $height <= 0) {
                return $file->store($folder, 'public');
            }

            // Dynamically boost memory limit if needed
            @ini_set('memory_limit', '1024M');

            // Create GD image resource based on detected image type
            $img = null;
            switch ($imageType) {
                case IMAGETYPE_JPEG:
                    $img = @imagecreatefromjpeg($realPath);
                    break;
                case IMAGETYPE_PNG:
                    $img = @imagecreatefrompng($realPath);
                    if ($img) {
                        imagealphablending($img, true);
                        imagesavealpha($img, true);
                    }
                    break;
                case IMAGETYPE_WEBP:
                    if (function_exists('imagecreatefromwebp')) {
                        $img = @imagecreatefromwebp($realPath);
                    }
                    break;
                default:
                    $content = @file_get_contents($realPath);
                    if ($content) {
                        $img = @imagecreatefromstring($content);
                    }
                    break;
            }

            if (!$img) {
                return $file->store($folder, 'public');
            }

            // Calculate dimensions and resize if larger than max width
            if ($width > $maxWidth) {
                $newWidth = $maxWidth;
                $newHeight = (int) round(($height / $width) * $newWidth);
                $resizedImg = imagescale($img, $newWidth, $newHeight);
                if ($resizedImg) {
                    imagedestroy($img);
                    $img = $resizedImg;
                    imagealphablending($img, true);
                    imagesavealpha($img, true);
                }
            }

            // Target filename & path on public disk
            $fileName = uniqid('img_') . '_' . time() . '.webp';
            $relativeFilePath = rtrim($folder, '/') . '/' . $fileName;
            $storagePath = Storage::disk('public')->path($relativeFilePath);

            // Ensure destination directory exists
            $dir = dirname($storagePath);
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }

            // Convert and save as WebP
            $saved = @imagewebp($img, $storagePath, $quality);
            imagedestroy($img);

            if ($saved && file_exists($storagePath) && filesize($storagePath) > 0) {
                return $relativeFilePath;
            }
        } catch (\Throwable $e) {
            Log::warning('Image compression fallback triggered: ' . $e->getMessage());
        }

        // Fallback: standard file storage
        return $file->store($folder, 'public');
    }
}

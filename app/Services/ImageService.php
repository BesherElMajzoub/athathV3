<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Upload and optionally convert to WebP.
     * Returns relative path like 'uploads/images/filename.webp'.
     */
    public function uploadToWebp(UploadedFile $file, string $folder = 'uploads/images'): array
    {
        $extension = $file->getClientOriginalExtension();
        $safeName = Str::uuid()->toString();

        // Native PHP GD WebP conversion
        // Using basic GD if image is jpeg or png
        $mime = $file->getMimeType();
        $path = '';

        if (function_exists('imagewebp') && in_array($mime, ['image/jpeg', 'image/png'])) {
            $image = null;
            if ($mime === 'image/jpeg') {
                $image = @imagecreatefromjpeg($file->getRealPath());
            } elseif ($mime === 'image/png') {
                $image = @imagecreatefrompng($file->getRealPath());
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
            }

            if ($image) {
                // Resize if needed here...
                $webpPath = "{$folder}/{$safeName}.webp";
                $fullPath = storage_path("app/public/{$webpPath}");
                
                if (!file_exists(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0755, true);
                }

                imagewebp($image, $fullPath, 85);
                imagedestroy($image);
                $path = $webpPath;
            } else {
                // fallback
                $path = $file->storeAs($folder, "{$safeName}.{$extension}", 'public');
            }
        } else {
            // fallback if no webp support or different format (e.g., gif, svg)
            $path = $file->storeAs($folder, "{$safeName}.{$extension}", 'public');
        }

        // Logic to generate an Arabic alt text could just be derived from the post title or general context,
        // but here we just return a generic placeholder that should be overridden by CMS user.
        return [
            'path' => $path,
            'alt' => 'أثاث مستعمل جدة - عرض تفصيلي',
            'url' => Storage::url($path),
        ];
    }
}

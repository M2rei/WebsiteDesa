<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public static function url(?string $path): string
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }

        return asset('images/placeholder.png');
    }
}

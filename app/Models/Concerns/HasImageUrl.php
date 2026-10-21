<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

trait HasImageUrl
{
    /**
     * Resolve a stored image path or absolute URL into a browser-ready URL.
     */
    public function imageUrl(?string $attribute = 'image'): ?string
    {
        $path = $this->getAttribute($attribute);

        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $url = Storage::disk('public')->url($path);

        return str_starts_with($url, 'http://') || str_starts_with($url, 'https://')
            ? $url
            : url($url);
    }
}

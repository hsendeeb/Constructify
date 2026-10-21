<?php

namespace App\Support;

class SiteLink
{
    /**
     * Resolve a stored link so home-page anchors work from every page.
     */
    public static function resolve(?string $url): string
    {
        if (blank($url)) {
            return '#';
        }

        if (str_starts_with($url, '#')) {
            return rtrim(route('home'), '/').'/'.$url;
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, 'mailto:') || str_starts_with($url, 'tel:')) {
            return $url;
        }

        return url($url);
    }

    /**
     * Build a dialable phone URL from a display number.
     */
    public static function phone(?string $phone): ?string
    {
        if (blank($phone)) {
            return null;
        }

        return 'tel:'.preg_replace('/[^0-9+]/', '', $phone);
    }
}

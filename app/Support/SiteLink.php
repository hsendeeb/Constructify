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

        $anchor = self::anchor($url);

        if ($anchor !== null) {
            return request()->routeIs('home')
                ? $anchor
                : rtrim(route('home'), '/').'/'.$anchor;
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, 'mailto:') || str_starts_with($url, 'tel:')) {
            return $url;
        }

        return url($url);
    }

    /**
     * Extract a same-page fragment from "#section" or "/#section" links.
     */
    public static function anchor(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        if (preg_match('/^\/?#([A-Za-z][\w-]*)$/', $url, $matches) === 1) {
            return '#'.$matches[1];
        }

        return null;
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

    /**
     * Build a mailto URL from a display email address.
     */
    public static function email(?string $email): ?string
    {
        if (blank($email)) {
            return null;
        }

        return 'mailto:'.trim($email);
    }
}

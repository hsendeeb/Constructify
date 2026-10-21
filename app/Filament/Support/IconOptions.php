<?php

namespace App\Filament\Support;

class IconOptions
{
    /**
     * Heroicons available for services, counters, and section badges.
     *
     * @return array<string, string>
     */
    public static function heroicons(): array
    {
        return [
            'heroicon-o-home-modern' => 'Home modern',
            'heroicon-o-building-office' => 'Building office',
            'heroicon-o-building-office-2' => 'Building office 2',
            'heroicon-o-building-library' => 'Building library',
            'heroicon-o-wrench-screwdriver' => 'Wrench & screwdriver',
            'heroicon-o-map' => 'Map',
            'heroicon-o-clipboard-document-check' => 'Clipboard check',
            'heroicon-o-pencil-square' => 'Pencil square',
            'heroicon-o-calendar-days' => 'Calendar',
            'heroicon-o-user-group' => 'User group',
            'heroicon-o-users' => 'Users',
            'heroicon-o-trophy' => 'Trophy',
            'heroicon-o-face-smile' => 'Smiley face',
            'heroicon-o-briefcase' => 'Briefcase',
            'heroicon-o-chart-bar' => 'Chart bar',
            'heroicon-o-truck' => 'Truck',
            'heroicon-o-shield-check' => 'Shield check',
            'heroicon-o-light-bulb' => 'Light bulb',
            'heroicon-o-cog-6-tooth' => 'Cog',
        ];
    }

    /**
     * Bootstrap Icons available for contact cards.
     *
     * @return array<string, string>
     */
    public static function contact(): array
    {
        return [
            'bi-telephone' => 'Phone',
            'bi-envelope' => 'Email',
            'bi-geo-alt' => 'Location',
            'bi-clock' => 'Clock',
            'bi-whatsapp' => 'WhatsApp',
            'bi-chat-dots' => 'Chat',
            'bi-globe2' => 'Website',
            'bi-buildings' => 'Building',
            'bi-link-45deg' => 'Link',
        ];
    }

    /**
     * Bootstrap Icons available for social links.
     *
     * @return array<string, string>
     */
    public static function social(): array
    {
        return [
            'bi-facebook' => 'Facebook',
            'bi-instagram' => 'Instagram',
            'bi-linkedin' => 'LinkedIn',
            'bi-twitter-x' => 'X (Twitter)',
            'bi-youtube' => 'YouTube',
            'bi-tiktok' => 'TikTok',
            'bi-whatsapp' => 'WhatsApp',
            'bi-globe2' => 'Website',
        ];
    }
}

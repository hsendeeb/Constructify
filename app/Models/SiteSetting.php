<?php

namespace App\Models;

use App\Models\Concerns\HasImageUrl;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'brand_name',
    'logo',
    'tagline',
    'phone',
    'phone_secondary',
    'email',
    'address',
    'working_hours',
    'map_embed_url',
    'footer_text',
    'copyright',
    'meta_title',
    'meta_description',
    'header_cta_text',
    'header_cta_url',
])]
class SiteSetting extends Model
{
    /** @use HasFactory<\Database\Factories\SiteSettingFactory> */
    use HasFactory;

    use HasImageUrl;

    /**
     * Retrieve the single settings record, creating an empty one when needed.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}

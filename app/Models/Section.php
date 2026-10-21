<?php

namespace App\Models;

use App\Models\Concerns\HasImageUrl;
use Database\Factories\SectionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'key',
    'label',
    'eyebrow',
    'title',
    'title_highlight',
    'subtitle',
    'image',
    'secondary_image',
    'background_image',
    'image_caption',
    'badge_text',
    'badge_icon',
    'primary_button_text',
    'primary_button_url',
    'secondary_button_text',
    'secondary_button_url',
    'is_active',
    'sort',
])]
class Section extends Model
{
    /** @use HasFactory<SectionFactory> */
    use HasFactory;

    use HasImageUrl;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Counters that belong to this section, matched by the section key.
     *
     * @return HasMany<Counter, $this>
     */
    public function counters(): HasMany
    {
        return $this->hasMany(Counter::class, 'section_key', 'key');
    }

    /**
     * @param  Builder<Section>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * @param  Builder<Section>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort');
    }

    public static function findByKey(string $key): ?self
    {
        return static::query()->where('key', $key)->first();
    }
}

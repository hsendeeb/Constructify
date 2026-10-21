<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'platform',
    'url',
    'icon',
    'sort',
    'is_active',
])]
class SocialLink extends Model
{
    /** @use HasFactory<\Database\Factories\SocialLinkFactory> */
    use HasFactory;

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
     * @param  Builder<SocialLink>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * @param  Builder<SocialLink>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort');
    }
}

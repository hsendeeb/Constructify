<?php

namespace App\Models;

use Database\Factories\FooterLinkGroupFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'title',
    'sort',
    'is_active',
])]
class FooterLinkGroup extends Model
{
    /** @use HasFactory<FooterLinkGroupFactory> */
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
     * Links that belong to this footer collection.
     *
     * @return HasMany<FooterLink, $this>
     */
    public function links(): HasMany
    {
        return $this->hasMany(FooterLink::class)->orderBy('sort');
    }

    /**
     * @param  Builder<FooterLinkGroup>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * @param  Builder<FooterLinkGroup>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort');
    }
}

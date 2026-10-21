<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'label',
    'url',
    'target',
    'sort',
    'is_active',
])]
class NavigationLink extends Model
{
    /** @use HasFactory<\Database\Factories\NavigationLinkFactory> */
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
     * @param  Builder<NavigationLink>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * @param  Builder<NavigationLink>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort');
    }
}

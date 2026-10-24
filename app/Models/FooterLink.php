<?php

namespace App\Models;

use Database\Factories\FooterLinkFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'footer_link_group_id',
    'label',
    'url',
    'target',
    'sort',
    'is_active',
])]
class FooterLink extends Model
{
    /** @use HasFactory<FooterLinkFactory> */
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
     * The collection this link belongs to.
     *
     * @return BelongsTo<FooterLinkGroup, $this>
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(FooterLinkGroup::class, 'footer_link_group_id');
    }

    /**
     * @param  Builder<FooterLink>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * @param  Builder<FooterLink>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort');
    }
}

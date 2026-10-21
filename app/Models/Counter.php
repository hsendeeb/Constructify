<?php

namespace App\Models;

use Database\Factories\CounterFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'section_key',
    'value',
    'label',
    'icon',
    'link_url',
    'sort',
    'is_active',
])]
class Counter extends Model
{
    /** @use HasFactory<CounterFactory> */
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
     * @param  Builder<Counter>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * @param  Builder<Counter>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort');
    }

    /**
     * @param  Builder<Counter>  $query
     */
    public function scopeForSection(Builder $query, string $sectionKey): void
    {
        $query->where('section_key', $sectionKey);
    }
}

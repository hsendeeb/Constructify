<?php

namespace App\Support;

use App\Models\Counter;
use Illuminate\Support\Collection;

class ContactDetails
{
    /**
     * Get the first contact card that holds a phone link.
     *
     * @param  Collection<int, Counter>  $cards
     */
    public static function phone(Collection $cards): ?Counter
    {
        return $cards->first(
            fn (Counter $card): bool => str_starts_with((string) $card->link_url, 'tel:')
        );
    }

    /**
     * Get the first contact card that holds an email link.
     *
     * @param  Collection<int, Counter>  $cards
     */
    public static function email(Collection $cards): ?Counter
    {
        return $cards->first(
            fn (Counter $card): bool => str_starts_with((string) $card->link_url, 'mailto:')
        );
    }
}

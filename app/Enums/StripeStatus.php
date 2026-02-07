<?php

namespace App\Enums;

enum StripeStatus:string
{
    case ACTIVE = 'active';

    case CANCELED = 'canceled';

    case PAST_DUE = 'past_due';

    case INCOMPLETE = 'incomplete';

    function label(): string
    {
        return match ($this) {
            self::ACTIVE => "Active",
            self::PAST_DUE => "Past Due",
            self::CANCELED => "Canceled",
            self::INCOMPLETE => "Incomplete",
        };
    }

}

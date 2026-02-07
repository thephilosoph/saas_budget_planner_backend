<?php

namespace App\Enums;

enum PlanName:string
{
case FREE = 'free';
case PRO = 'pro';
case ENTERPRISE = 'enterprise';

    function label(): string
    {
        return match ($this) {
            self::FREE => "Free",
            self::PRO => "Pro",
            self::ENTERPRISE => "Enterprise",
        };
    }
}

<?php

namespace App\Enums;

enum CategoryType:string
{
case INCOME = "income";

case EXPENSE = "expense";

case TRANSFER = "transfer";


function label(): string
{
    return match ($this) {
        self::INCOME => "Income",
        self::EXPENSE => "Expense",
        self::TRANSFER => "Transfer",
    };
}

}

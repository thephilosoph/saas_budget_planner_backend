<?php

namespace App\Enums;

enum TransactionType:string
{

case INCOME = "income";
case EXPENSE = "expense";


function label(): string
{
    return match ($this) {
        self::INCOME => "Income",
        self::EXPENSE => "Expense",
    };
}
}

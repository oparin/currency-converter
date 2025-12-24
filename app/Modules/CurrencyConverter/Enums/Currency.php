<?php

namespace App\Modules\CurrencyConverter\Enums;

enum Currency: string
{
    case USD = 'usd';
    case EUR = 'eur';
    case RUB = 'rub';

    public function label(): string
    {
        return match ($this) {
            self::USD => 'US Dollar',
            self::EUR => 'Euro',
            self::RUB => 'Russian Ruble',
        };
    }
}

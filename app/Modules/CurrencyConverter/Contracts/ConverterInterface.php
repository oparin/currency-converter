<?php

namespace App\Modules\CurrencyConverter\Contracts;

use Exception;
use InvalidArgumentException;

/**
 * Interface for currency conversion functionality.
 *
 * This interface defines the contract for currency conversion services to implement.
 * It provides methods for converting amounts between different currencies and
 * retrieving exchange rates.
 *
 * The purpose of this interface is to standardize the interaction with currency
 * conversion services, allowing for easy switching between different providers.
 *
 * Usage example:
 *
 * $converter = new CurrencyConverter();
 * $amountInEUR = $converter->convert(100, 'USD', 'EUR');
 *
 * @package App\Modules\CurrencyConverter\Contracts
 */
interface ConverterInterface
{
    /**
     * Convert an amount from one currency to another.
     *
     * This method takes an amount in the source currency and converts it to
     * the target currency using the current exchange rate.
     *
     * @example
     * $converter->convert(100, 'USD', 'EUR'); // Returns amount in EUR
     *
     * @param float $amount Amount to convert (must be a positive number)
     * @param string $fromCurrency Source currency code (e.g., 'USD', 'EUR')
     * @param string $toCurrency Target currency code (e.g., 'RUB', 'KZT')
     * @return float Converted amount in target currency
     * @throws InvalidArgumentException If currency codes are invalid
     * @throws Exception If conversion fails or rate is not available
     */
    public function convert(float $amount, string $fromCurrency, string $toCurrency): float;
}

<?php

namespace App\Modules\CurrencyConverter\Rules;

use Closure;
use App\Modules\CurrencyConverter\Services\ApiService;
use Illuminate\Contracts\Validation\ValidationRule;
class Exist implements ValidationRule
{
    private ApiService $apiService;

    public function __construct()
    {
        $this->apiService = app(ApiService::class);
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $currencies = $this->apiService->getAvailableCurrencies();

        if (!isset($currencies[strtoupper($value)])) {
            $fail('The :attribute currency is not exist.');
        }
    }
}

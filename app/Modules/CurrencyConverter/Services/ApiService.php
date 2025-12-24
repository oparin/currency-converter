<?php

namespace App\Modules\CurrencyConverter\Services;

use GuzzleHttp\Client;

class ApiService
{
    private Client $client;
    private string $apiKey;
    private string $baseUrl = 'https://api.freecurrencyapi.com/v1/';

}

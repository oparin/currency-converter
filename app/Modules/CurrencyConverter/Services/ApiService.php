<?php

namespace App\Modules\CurrencyConverter\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ApiService
{
    private Client $client;
    private string $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('currency-converter.base_url'),
            'timeout'  => 30,
            'headers'  => [
                'Accept' => 'application/json',
            ],
        ]);

        $this->apiKey = config('currency-converter.api_key');
    }

    public function getLatestRates(string $baseCurrency = 'USD')
    {
        try {
            $response = $this->client->get('latest', [
                'query' => [
                    'apikey'        => $this->apiKey,
                    'base_currency' => $baseCurrency,
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (empty($data['data'])) {
                throw new \Exception('Invalid response from API');
            }

            return $data['data'];
        } catch (\Exception $e) {
            Log::error('Failed to fetch exchange rates: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getAvailableCurrencies(): array
    {
        try {
            $response = $this->client->get('currencies', [
                'query' => ['apikey' => $this->apiKey]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data['data'] ?? [];
        } catch (\Exception $e) {
            Log::error('Failed to fetch currencies: ' . $e->getMessage());
            return [];
        }
    }
}

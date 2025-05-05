<?php

namespace App\Drivers\Currency;

use App\Config;
use App\Contracts\Currency\ExchangeRateProviderInterface;
use App\Http\HttpClient;

class ExchangeRateApiProvider implements ExchangeRateProviderInterface
{

    public function getRate(string $currency): float
    {
        $url = Config::get('app.exchangerate_provider.api_url');

        $client = new HttpClient();

        $response = $client->get($url);

        if ($response['success'] !== true) {
            throw new \Exception($response['error']['info']);
        }

        return $response['rates'][$currency] ?? 0;
    }
}
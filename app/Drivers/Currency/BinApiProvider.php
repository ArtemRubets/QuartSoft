<?php

namespace App\Drivers\Currency;

use App\Config;
use App\Contracts\Currency\BinProviderInterface;
use App\Http\HttpClient;

class BinApiProvider implements BinProviderInterface
{
    public function getCountryCode(string $bin): string
    {
        $url = Config::get('app.bin_provider.api_url');

        $client = new HttpClient();

        $response = $client->setHeaders([
            'Accept-Version: 3',
            'Accept: application/json',
            'Content-Type: application/json'
        ])->get($url . '/' . $bin);

        if (!isset($response['country']['alpha2'])) {
            throw new \Exception('Country code not found');
        }
        return $response['country']['alpha2'];
    }
}
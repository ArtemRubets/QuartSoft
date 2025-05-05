<?php

namespace App\Drivers\Currency;

use App\Config;
use App\Contracts\Currency\ExchangeRateProviderInterface;

class ExchangeRateProviderFactory
{
    public static function create(): ExchangeRateProviderInterface
    {
        $driver = Config::get('app.exchangerate_provider.driver');

        return match ($driver) {
            'api' => new ExchangeRateApiProvider(),
            'database' => new ExchangeRateDatabaseProvider(),
//            'other_source' => new ExchangeRateSomethingElseProvider(),
            default => throw new \Exception("Unknown bin provider: $driver"),
        };
    }
}
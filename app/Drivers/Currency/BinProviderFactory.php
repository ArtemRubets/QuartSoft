<?php

namespace App\Drivers\Currency;

use App\Config;
use App\Contracts\Currency\BinProviderInterface;

class BinProviderFactory
{
    public static function create(): BinProviderInterface
    {
        $driver = Config::get('app.bin_provider.driver');

        return match ($driver) {
            'api' => new BinApiProvider(),
            'database' => new BinDatabaseProvider(),
//            'other_source' => new BinSomethingElseProvider(),
            default => throw new \Exception("Unknown bin provider: $driver"),
        };
    }
}
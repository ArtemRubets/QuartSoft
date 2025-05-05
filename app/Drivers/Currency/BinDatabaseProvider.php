<?php

namespace App\Drivers\Currency;

use App\contracts\Currency\BinProviderInterface;

class BinDatabaseProvider implements BinProviderInterface
{
    public function getCountryCode(string $bin): ?string
    {
        // grab from database
    }
}
<?php

namespace App\Drivers\Currency;

use App\contracts\Currency\BinProviderInterface;

class BinSomethingElseProvider implements BinProviderInterface
{
    public function getCountryCode(string $bin): ?string
    {
        // get data from another source
    }
}
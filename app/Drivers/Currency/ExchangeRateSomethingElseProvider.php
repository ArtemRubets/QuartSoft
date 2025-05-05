<?php

namespace App\Drivers\Currency;

use App\contracts\Currency\ExchangeRateProviderInterface;

class ExchangeRateSomethingElseProvider implements ExchangeRateProviderInterface
{
    public function getRate(string $currency): float
    {
        // TODO: Implement getRate() method.
    }
}
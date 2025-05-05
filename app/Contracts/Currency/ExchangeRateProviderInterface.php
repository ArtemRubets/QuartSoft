<?php

namespace App\Contracts\Currency;

interface ExchangeRateProviderInterface
{
    public function getRate(string $currency): float;
}
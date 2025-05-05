<?php

namespace App;

use App\contracts\Currency\BinProviderInterface;
use App\contracts\Currency\ExchangeRateProviderInterface;
use App\Drivers\Currency\BinProviderFactory;
use App\Drivers\Currency\ExchangeRateProviderFactory;

class Currency
{

    protected BinProviderInterface $binProvider;
    protected ExchangeRateProviderInterface $rateProvider;

    public function __construct()
    {
        $this->binProvider = BinProviderFactory::create();
        $this->rateProvider = ExchangeRateProviderFactory::create();
    }

    const AVAILABLE_CURRENCIES = [
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI',
        'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT',
        'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK',
    ];

    public function calculateCommission(array $row): float
    {
        $currency = $row['currency'];
        $amount = $row['amount'];
        $bin = $row['bin'];

        $country = $this->binProvider->getCountryCode($bin);

        $rate = $this->rateProvider->getRate($currency);

        if ($currency === 'EUR' || $rate == 0) {
            $amountFixed = $amount;
        }
        if ($currency !== 'EUR' && $rate > 0) {
            $amountFixed = $amount / $rate;
        }
        return $amountFixed * ($this->isEu($country) ? 0.01 : 0.02);
    }

    public function isEu($currency): bool
    {
        return in_array($currency, self::AVAILABLE_CURRENCIES,);
    }
}
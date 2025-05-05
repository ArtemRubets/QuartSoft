<?php

namespace App\Contracts\Currency;

interface BinProviderInterface
{
    public function getCountryCode(string $bin): ?string;
}
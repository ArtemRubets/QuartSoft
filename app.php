<?php

require __DIR__ . '/vendor/autoload.php';

use App\Config;
use App\Currency;

$fileContents = file_get_contents('data/input.json');

$rows = json_decode($fileContents, true);

// init config, but it must be singleton
$config = new Config();

foreach ($rows as $row) {
    if (empty($row)) break;

    $commission = (new Currency())->calculateCommission($row);

    echo $commission;
    print "\n";
}

die();
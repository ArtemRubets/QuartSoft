<?php

namespace App;

class Config
{
    private static array $configs = [];

    public function __construct()
    {
        $files = glob('config/*.xml');

        if ($files) {
            foreach ($files as $file) {
                $configName = pathinfo($file, PATHINFO_FILENAME);

                self::$configs[$configName] = \simplexml_load_file($file);
            }
        }
    }

    public static function get($key): mixed
    {
        $parts = explode('.', $key);
        $fileKey = array_shift($parts);
        $path = implode('/', $parts);

        if (!isset(self::$configs[$fileKey])) {
            return null;
        }

        $xml = self::$configs[$fileKey];
        $result = $xml->xpath($path);

        if (!$result || empty($result[0])) {
            return null;
        }

        return (string) $result[0];
    }
}
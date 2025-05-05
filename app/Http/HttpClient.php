<?php

namespace App\Http;

use CurlHandle;

class HttpClient
{
    const HTTP_OK = 200;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_NOT_FOUND = 404;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_TOO_MANY_REQUESTS = 429;

    private CurlHandle $ch;

    protected array $headers = [];

    public function __construct()
    {
        $this->ch = $this->init();
    }

    public function get(string $url, array $params = [])
    {
        return $this->execute($url, $params);
    }

    public function post(string $url, array $params = [])
    {
        curl_setopt($this->ch, CURLOPT_POST, true);

        if ($params) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }

        return $this->execute($url, $params);
    }

    private function init(): CurlHandle|false
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return $ch;
    }

    private function close()
    {
        curl_close($this->ch);
    }

    private function execute(string $url, array $params = []): array|null
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->getHeaders());

        $response = curl_exec($this->ch);

        $httpCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

        if ($response === false || $httpCode !== self::HTTP_OK) {
            $errorMessage = curl_error($this->ch);

            if ($httpCode === self::HTTP_TOO_MANY_REQUESTS) {
                $errorMessage = 'Too many requests';
            }

            throw new \Exception('Curl error: ' . $errorMessage);
        }

        $this->close();

        return json_decode($response, true);
    }

    public function setHeaders(array $headers): HttpClient
    {
        $this->headers = $headers;

        return $this;
    }

    private function getHeaders(): array
    {
        return $this->headers;
    }
}
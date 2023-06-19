<?php

namespace App\Services\TMDB;

use Illuminate\Support\Facades\Http;
use PhpParser\Error;

class TMDBService
{
    protected $apiUrl;
    protected $apiKey;
    protected $collectionKey;

    public function __construct()
    {
        $this->setApiUrl(config('services.tmdb.api_url'));
        $this->setApiKey(config('services.tmdb.api_key'));
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl . $this->getCollectionKey();
    }

    public function setCollectionKey($key)
    {
        $this->collectionKey = '/' . $key;
    }

    public function send($method, $endpoint, $params = [], $format = 'object')
    {
        $queryParams = array_merge([
            'api_key' => $this->getApiKey(),
            'language' => 'en-US',
        ], $params);
        $httpParams = ['query' => $queryParams];

        $response = Http::send(strtoupper($method), $this->getApiUrl() . $endpoint, $httpParams);
        return $response->{$format}();
    }

    protected function getApiKey()
    {
        return $this->apiKey;
    }

    protected function getApiUrl()
    {
        return $this->apiUrl;
    }

    protected function getCollectionKey()
    {
        return $this->collectionKey;
    }
}

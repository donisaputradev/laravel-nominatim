<?php

namespace App\Services;

use GuzzleHttp\Client;

class NominatimService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://nominatim.openstreetmap.org', 'headers' => [
            'User-Agent' => 'LaravelNominatimBackup/1.0 (donisaputradev@gmail.com)'
        ]]);
    }

    public function get($url, $query = [])
    {
        $response = $this->client->get($url, ['query' => $query]);

        return json_decode($response->getBody()->getContents(), true);
    }
}

<?php

namespace App\Services;

use GuzzleHttp\Client;

class NominatimService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => env('NOMINATIM_URL'), 'headers' => [
            'User-Agent' => env('USER_AGENT'),
        ]]);
    }

    public function get($url, $query = [])
    {
        $response = $this->client->get($url, ['query' => $query]);

        return json_decode($response->getBody()->getContents(), true);
    }
}

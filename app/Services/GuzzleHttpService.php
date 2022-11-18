<?php

namespace App\Services;

use GuzzleHttp\Client;

/**
 * Class GuzzleHttpService.
 */
class GuzzleHttpService
{
    public function httpClient(): Client
    {
        return new Client();
    }
}

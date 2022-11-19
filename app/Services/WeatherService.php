<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class WeatherService.
 */
class WeatherService
{
    // third party weather API
    protected string $weatherApi = 'https://api.openweathermap.org/data/2.5/weather?q=';

    public function httpClient(): Client
    {
        return new Client();
    }

    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function weatherLocationApi($state, $country){
        // Weather API key gotten from .env file
        $url = $this->weatherApi.$state.",".$country."&appid=".@env('WEATHER_API_KEY');
        $params = [];
        $headers = [];
        $response = $this->httpClient()->request('GET', $url, [
             'json' => $params,
            'headers' => $headers,
            'verify'  => false,
        ]);

        // return data to controller
        return json_decode($response->getBody(), false, 512, JSON_THROW_ON_ERROR);
    }
}

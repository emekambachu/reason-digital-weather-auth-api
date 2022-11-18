<?php

namespace App\Services;

use GuzzleHttp\Exception\GuzzleException;

/**
 * Class WeatherService.
 */
class WeatherService
{
    public string $weatherApi = 'https://api.openweathermap.org/data/2.5/weather?q=';

    private GuzzleHttpService $http;
    public function __construct(GuzzleHttpService $http){
        $this->http = $http;
    }

    /**
     * @throws GuzzleException
     */
    public function weatherLocationApi($state, $country){

        $url = $this->weatherApi.$state.",".$country."&appid=".@env('WEATHER_API_KEY');
        $params = [];
        $headers = [];
        $response = $this->http->httpClient()->request('GET', $url, [
             'json' => $params,
            'headers' => $headers,
            'verify'  => false,
        ]);

        return json_decode($response->getBody(), false, 512, JSON_THROW_ON_ERROR);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\GuzzleHttpService;
use App\Services\WeatherService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    private WeatherService $weather;
    public function __construct(WeatherService $weather){
        $this->weather = $weather;
    }

    public function weatherByLocation($state, $country = ''){
        try {
           return $this->weather->weatherLocationApi($state, $country);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}

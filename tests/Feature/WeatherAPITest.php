<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WeatherAPITest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest_users_cannot_use_weather_api(): void
    {
        $this->json('GET', url('/api/weather/location/{state}/{country}'))
            ->assertStatus(401);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class WeatherAPITest extends TestCase
{
    use RefreshDatabase, WithFaker;
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

    public function test_logged_in_user_can_use_weather_api(): void
    {
        $this->withoutExceptionHandling();

        // create user
        $user = User::factory()->create();
        // login
        $this->json('POST', url('/api/auth/login'), [
            'email' => $user->email,
            'password' => 'password',
        // Check successful login
        ])->assertStatus(200)->assertJson(static function (AssertableJson $json) use ($user){
            $json->has('access_token')
                ->where('user.email', $user->email)
                ->where('user.name', $user->name)
                ->etc();
        });

        // Access API with logged in user
        $this->actingAs($user)->json('GET', url('/api/weather/location/{state}/{country}'))
            ->assertStatus(200);
    }
}

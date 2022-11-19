<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserAuthenticationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_registration(): void
    {
        $this->withoutExceptionHandling();

        // Register user with api and check success code
        $user = User::factory()->create();
        $this->json('POST', url('/api/auth/register'), [
            'email' => $user->email,
            'password' => Hash::make('password'),
        ])->assertStatus(200);

        // Check if registered user data exists in database
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'name' => $user->name
        ]);
    }

    public function test_user_login(): void
    {
        $this->withoutExceptionHandling();

        // Create user, Log them in using the login API
        $user = User::factory()->create();
        $this->json('POST', url('/api/auth/login'), [
            'email' => $user->email,
            'password' => 'password',

        // test for successful status code and if json data key exists
        ])->assertStatus(200)->assertJson(static function (AssertableJson $json) use ($user){
            $json->has('access_token')
                ->where('user.email', $user->email)
                ->where('user.name', $user->name)
                ->etc();
        });
    }
}

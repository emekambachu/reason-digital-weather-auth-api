<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
], static function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);
    Route::get('/user', [AuthController::class, 'profile']);
    Route::get('/weather/location/{state}/{country?}', [WeatherController::class, 'weatherByLocation']);
});

//Route::post('/auth/register', [AuthController::class, 'register']);
//Route::post('/auth/login', [AuthController::class, 'login']);
//Route::post('/auth/logout', [AuthController::class, 'logout']);



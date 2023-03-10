<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function (Request $request) {
        return auth()->user();
    });
    /* Route::get('user', [ClientController::class, 'index']);
    Route::post('user', [ClientController::class, 'store']);
    Route::get('user', [ClientController::class, 'show']);
    Route::put('client', [ClientController::class, 'update']);
    Route::delete('client', [ClientController::class, 'delete']);*/
    Route::resource('user.client', ClientController::class)->only('index', 'show', 'store', 'update', 'destroy');
    Route::resource('city', CityController::class)->only('index', 'show');
    Route::post('/logout', [AuthController::class, 'logout']);
});
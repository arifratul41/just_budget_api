<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;

use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/token', [AccessTokenController::class, 'issueToken'])->middleware('throttle');
Route::post('/tokens', [PersonalAccessTokenController::class, 'store'])->middleware('auth:api');
Route::delete('/tokens/{token_id}', [PersonalAccessTokenController::class, 'destroy'])->middleware('auth:api');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
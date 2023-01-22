<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\clientsController;
use App\Http\Controllers\creditsController;
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
Route::middleware('auth:api')->post('/creditWorthiness', [creditsController::class, 'creditWorthiness']);
Route::middleware('auth:api')->get('/businessExperienceScore/{date}', [creditsController::class, 'businessExperienceScore']);
Route::middleware('auth:api')->post('/test', [clientsController::class, 'test']);
Route::middleware('auth:api')->post('/sum', function(Request $request){
    
    return $request->one + $request->two;
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

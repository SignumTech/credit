<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\clientsController;
use Carbon\Carbon;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function () {
    dd(Carbon::now()->diffInDays(Carbon::parse('2022-12-01'),false));
});
Route::middleware('auth')->get('/getClients', [clientsController::class, 'getClients']);
Route::middleware('auth')->get('/getParameters/{id}', [clientsController::class, 'getParameters']);
Route::middleware('auth')->get('/showClient/{id}', [clientsController::class, 'showClient']);
Route::middleware('auth')->put('/initializeParameters/{id}', [clientsController::class, 'initializeParameters']);
Route::middleware('auth')->put('/updateWorthiness/{id}', [clientsController::class, 'updateWorthiness']);
Route::middleware('auth')->put('/updateCreditScore/{id}', [clientsController::class, 'updateCreditScore']);
Route::middleware('auth')->put('/updateCutoff/{id}', [clientsController::class, 'updateCutoff']);

/*Route::middleware('auth')->get('/getClients', function(Request $request){
    return $request->user()->clients;
});*/
Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/', function () {
    return view('home');
});
Auth::routes();
Route::any('{slug}', function () {
    return view('home');
});
Route::any('/app/{slug}', function () {
    return view('home');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

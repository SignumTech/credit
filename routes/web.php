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

Route::get('/', function () {
    return view('home');
});
Route::get('/test', function () {
    dd(Carbon::now()->diffInDays(Carbon::parse('2022-12-01'),false));
});
Route::middleware('auth')->get('/getClients', [clientsController::class, 'getClients']);
/*Route::middleware('auth')->get('/getClients', function(Request $request){
    return $request->user()->clients;
});*/
Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

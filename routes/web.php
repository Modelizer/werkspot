<?php

use App\Http\Controllers\UrlShortenerController;
use App\Http\Middleware\SplitTesting;
use Illuminate\Support\Facades\Route;

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

Route::middleware(SplitTesting::class)
    ->get('/{shortUrl}', [UrlShortenerController::class, 'index']);

Route::get('/', function () {
    return view('welcome');
});

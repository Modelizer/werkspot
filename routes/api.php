<?php

use App\Http\Controllers\UrlShortenerController;
use App\Http\Middleware\SplitTesting;
use Illuminate\Support\Facades\Route;

Route::middleware(SplitTesting::class)
    ->post('/url', [UrlShortenerController::class, 'store']);

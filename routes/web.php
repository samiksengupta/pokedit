<?php

use Illuminate\Support\Facades\Route;

// Catch-all route for the SPA
Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!api).*$'); // Exclude routes starting with "api"

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokeApiResourceController;

// Group routes with a common prefix
Route::group(['prefix' => 'pokeapi'], function () {
    Route::get('resource', [PokeApiResourceController::class, 'resource'])->name('resource');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThirdPartyResourceController;

// Group routes with a common prefix
Route::group(['prefix' => 'pokeapi'], function () {
    Route::get('resource', [ThirdPartyResourceController::class, 'resource'])->name('resource');
    Route::get('resource/{id}', [ThirdPartyResourceController::class, 'resourceShow'])->name('resource.show');
});

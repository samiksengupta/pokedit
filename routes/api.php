<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokeApiResourceController;

// Group routes with a common prefix
Route::group(['prefix' => 'pokeapi'], function () {
    Route::get('resources', [PokeApiResourceController::class, 'index'])->name('resources.index');
    Route::get('resources/{type}/{id}', [PokeApiResourceController::class, 'show'])->name('resources.show');
    Route::delete('resources/{type}', [PokeApiResourceController::class, 'destroy'])->name('resources.destroy');
});

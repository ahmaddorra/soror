<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
*/

Route::get('pharmacies', [App\Http\Controllers\Client\PharmacyController::class, "index"])->name('pharmacies.index');

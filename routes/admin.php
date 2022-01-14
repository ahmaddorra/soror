<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::resource('pharmacies', App\Http\Controllers\Admin\PharmacyController::class)->except('create', 'edit');


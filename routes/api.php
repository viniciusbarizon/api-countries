<?php

use App\Http\Controllers\CountryController;
use Illuminate\Support\Facades\Route;

Route::apiResource('countries', CountryController::class);

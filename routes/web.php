<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CovidDataController;

Route::get('/', [CovidDataController::class, 'showCovidData'])->name('showCovidData');;

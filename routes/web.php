<?php

use Illuminate\Support\Facades\Route;
use App\Services\CovidStatisticService;

Route::get('/', [CovidStatisticService::class, 'getTotalCovidData']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CovidDataController;

Route::get('/', [CovidDataController::class, 'refreshTable'])->name('refreshData');;
Route::get('/update', [CovidDataController::class, 'updateData'])->name('updateData');;

<?php

use App\Http\Controllers\MortgageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MortgageController::class, 'index']);
Route::post('/calculate', [MortgageController::class, 'calculate'])->name('mortgage.calculate');

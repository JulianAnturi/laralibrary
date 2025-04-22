<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LendController;

Route::apiResource('lend', LendController::class);
Route::post('return/{id}', [LendController::class, 'returnBook']);

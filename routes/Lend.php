<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LendController;

Route::apiResource('lend', LendController::class);

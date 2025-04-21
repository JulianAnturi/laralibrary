<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;

// Route::middleware('auth:sanctum')->group(function () {
Route::apiResource('people', PersonController::class);
// });

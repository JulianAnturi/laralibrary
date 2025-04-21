<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

// Route::middleware('auth:sanctum')->group(function () {
Route::apiResource('books', BookController::class);
// });

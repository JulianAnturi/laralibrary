<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Anturi\Larastarted\Helpers\ResponseService;

Route::get('/', function () {
    return    ResponseService::responseGet(["welcome" => "to the best library"]);
});

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::fallback(function () {
    return response()->json(['statusCode' => 404, 'status' => "error", 'message' => 'not found!'], 404, ['Content-Type' => 'application/json']);
});

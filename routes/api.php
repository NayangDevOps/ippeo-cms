<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API routes for future expansion
Route::prefix('v1')->group(function () {
    // Public API routes can be added here
});

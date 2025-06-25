<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClockingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);

Route::middleware('auth:sanctum')->post('/clocking-days/{date}/clock-in', [ClockingController::class, 'clockIn']);
Route::middleware('auth:sanctum')->post('/clocking-days/{date}/clock-out', [ClockingController::class, 'clockOut']);
Route::middleware('auth:sanctum')->post('/clocking-days/{date}/coffee-break-in', [ClockingController::class, 'coffeeBreakIn']);
Route::middleware('auth:sanctum')->post('/clocking-days/{date}/coffee-break-out', [ClockingController::class, 'coffeeBreakOut']);
Route::middleware('auth:sanctum')->post('/clocking-days/{date}/lunch-break-in', [ClockingController::class, 'lunchBreakIn']);
Route::middleware('auth:sanctum')->post('/clocking-days/{date}/lunch-break-out', [ClockingController::class, 'lunchBreakOut']);

<?php

use App\Http\Controllers\Api\Driver\DriverController as DriverApiController;
use App\Http\Controllers\Api\Driver\RideController as DriverRideController;
use App\Http\Controllers\Api\Passenger\RideController as PassengerRideController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix("passenger")->group(function () {
    Route::post("/rides", [PassengerRideController::class, "store"]);
    Route::post("/rides/{ride}/approve-driver", [PassengerRideController::class, "approveDriver"]);
    Route::post("/rides/{ride}/complete", [PassengerRideController::class, "complete"]);
});

Route::prefix("driver")->group(function () {
    Route::post("/location", [DriverApiController::class, "updateLocation"]);
    Route::get("/rides/nearby", [DriverApiController::class, "nearbyRides"]);
    Route::post("/rides/{ride}/request", [DriverRideController::class, "requestRide"]);
    Route::post("/rides/{ride}/complete", [DriverRideController::class, "complete"]);
});

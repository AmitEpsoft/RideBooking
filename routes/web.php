<?php

use App\Http\Controllers\Admin\RideController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get("/", function () {
    return redirect()->route("admin.rides.index");
});

Route::prefix("admin")->name("admin.")->group(function () {
    Route::get("/rides", [RideController::class, "index"])->name("rides.index");
    Route::get("/rides/{ride}", [RideController::class, "show"])->name("rides.show");
});

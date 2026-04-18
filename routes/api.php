<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();


});

    Route::get('/slots', [BookingController::class, 'getSlots']);
    Route::post('/book', [BookingController::class, 'bookAppointment']);
    Route::get('/get-types', [BookingController::class, 'getTypes']);
    Route::get('/admin/slots', [App\Http\Controllers\AppointmentController::class, 'getAvailableSlots']);
   // Route::get('/slots', [BookingController::class, 'getSlots']);

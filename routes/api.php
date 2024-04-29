<?php

use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\ServiceController;
use App\Models\Apartment;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::name('api.')->group(function () {
    Route::get('/guest/apartments', [ApartmentController::class, 'index'])->name('guest.apartments.index');
    Route::get('/guest/apartments/search', [ApartmentController::class, 'search'])->name('guest.apartments.search');
    Route::get('/guest/apartments/{apartment}', [ApartmentController::class, 'show'])->name('guest.apartments.show');
    Route::get('/apartment/services', [ApartmentController::class, 'services'])->name('apartment.services');
    Route::post('/contact-us/{apartment}',[ LeadController::class, 'store' ])->name('leads.store');
});
// Route::apiResource('/services', ServiceController::class);
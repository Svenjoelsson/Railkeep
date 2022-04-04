<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('customers', App\Http\Controllers\API\CustomersAPIController::class);


Route::resource('vendors', App\Http\Controllers\API\VendorsAPIController::class);

Route::resource('contacts', App\Http\Controllers\API\contactsAPIController::class);


Route::resource('services', App\Http\Controllers\API\ServicesAPIController::class);


Route::resource('units', App\Http\Controllers\API\UnitsAPIController::class);


Route::resource('activities', App\Http\Controllers\API\ActivitiesAPIController::class);


Route::resource('service_vendors', App\Http\Controllers\API\serviceVendorAPIController::class);


Route::resource('service_types', App\Http\Controllers\API\serviceTypeAPIController::class);



Route::resource('rents', App\Http\Controllers\API\RentAPIController::class);


Route::resource('inventories', App\Http\Controllers\API\inventoryAPIController::class);


Route::resource('make_lists', App\Http\Controllers\API\makeListAPIController::class);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/v1/company')->group(function(){
    Route::get('/', [\App\Http\Controllers\CompanyController::class,'index']);
    Route::get('/{id}', [\App\Http\Controllers\CompanyController::class,'findById']);

    Route::post('/', [\App\Http\Controllers\CompanyController::class,'create']);
    Route::put('/{id}', [\App\Http\Controllers\CompanyController::class,'updateById']);
    Route::delete('/{id}', [\App\Http\Controllers\CompanyController::class,'destroy']);

});

Route::prefix('/v1/station')->group(function(){
    Route::get('/', [\App\Http\Controllers\StationController::class,'index']);
    Route::get('/{id}', [\App\Http\Controllers\StationController::class,'findById']);

    Route::post('/', [\App\Http\Controllers\StationController::class,'create']);
    Route::put('/{id}', [\App\Http\Controllers\StationController::class,'updateById']);
    Route::delete('/{id}', [\App\Http\Controllers\StationController::class,'destroy']);


});

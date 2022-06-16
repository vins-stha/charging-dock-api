<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('/company/',[\App\Http\Controllers\CompanyController::class,'index']);
Route::get('/company/list', function () {
    return view('company.index');
});
Route::get('/company/create', function () {
    return view('company.index');
});

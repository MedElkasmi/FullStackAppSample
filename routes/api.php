<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

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

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/products',[ProductController::class,'store']);
    Route::get('/products',[ProductController::class,'index']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

});

Route::post('/register',[RegisterController::class,'register']);
Route::post('/login',[LoginController::class,'login']);






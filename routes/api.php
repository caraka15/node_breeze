<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExordeHistoryController;
use App\Http\Controllers\MultiplierController;

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


Route::get('/exorde-history', [ExordeHistoryController::class, 'getReputationHistory']);

Route::get('/multipliers', [MultiplierController::class, 'getMultipliers']);
Route::post('/multipliers', [MultiplierController::class, 'updateMultipliers'])->middleware(['auth:sanctum', 'isAdmin']);

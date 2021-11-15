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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/scan', [\App\Http\Controllers\ScanController::class, 'scan']);
    Route::get('/file/{id}', [\App\Http\Controllers\FileContentController::class, 'show']);
    Route::get('/files', [\App\Http\Controllers\UserController::class, 'files']);
});

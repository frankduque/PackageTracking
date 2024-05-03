<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PackageController;

Route::post('authenticate', [AuthenticatedSessionController::class, 'authenticate']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/list-packages', [PackageController::class, 'listPackages']);
    Route::post('/store-packages', [PackageController::class, 'store']);
    Route::get('/update-package/{codigo}', [PackageController::class, 'updatePackage']);
});


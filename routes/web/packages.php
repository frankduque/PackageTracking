<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PackageController;
use Illuminate\Support\Facades\Route;

Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
Route::get('/packages/{package}/details', [PackageController::class, 'details'])->name('packages.details');
Route::delete('/packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');

//packages ready for deletion
Route::get('/packages/ready-for-deletion', [PackageController::class, 'readyForDeletion'])->name('packages.ready-for-deletion');
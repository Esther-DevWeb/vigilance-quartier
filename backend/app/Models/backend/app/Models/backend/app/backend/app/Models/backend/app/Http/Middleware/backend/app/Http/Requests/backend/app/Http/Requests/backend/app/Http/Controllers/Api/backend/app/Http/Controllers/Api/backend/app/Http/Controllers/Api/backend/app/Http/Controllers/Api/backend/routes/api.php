<?php

use App\Http\Controllers\Api\AlertController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\IncidentController;
use App\Http\Controllers\Api\IncidentTypeController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/incidents', [IncidentController::class, 'index']);
Route::get('/incidents/{incident}', [IncidentController::class, 'show']);
Route::get('/incident-types', [IncidentTypeController::class, 'index']);
Route::get('/alerts', [AlertController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/incidents', [IncidentController::class, 'store']);

    Route::middleware('is_admin')->group(function () {
        Route::get('/admin/incidents', [IncidentController::class, 'adminIndex']);
        Route::patch('/incidents/{incident}/status', [IncidentController::class, 'updateStatus']);
        Route::post('/alerts', [AlertController::class, 'store']);
    });
});

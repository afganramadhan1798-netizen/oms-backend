<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ProfileController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::post('/form', [FormController::class, 'submit']);

     // REVIEW APPROVAL
    Route::get('/approvals', [ApprovalController::class, 'index']);
    Route::post('/approvals/{id}/approve', [ApprovalController::class, 'approve']);
    Route::post('/approvals/{id}/reject', [ApprovalController::class, 'reject']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
});
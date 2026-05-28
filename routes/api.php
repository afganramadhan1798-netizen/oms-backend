<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    // form
    Route::post('/form', [FormController::class, 'submit']);
    // review approvals
    Route::get('/approvals', [ApprovalController::class, 'index']);
    Route::post('/approvals/{id}/approve', [ApprovalController::class, 'approve']);
    Route::post('/approvals/{id}/reject', [ApprovalController::class, 'reject']);
    // profile
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::delete('/profile/delete-photo', [ProfileController::class, 'deletePhoto']);
    // hr
    Route::post('/overtimes/{id}/hr-approve', [ApprovalController::class,'hrApprove']);
    Route::post('/overtimes/{id}/hr-reject', [ApprovalController::class,'hrReject']);
    // edit(resubmit)
    Route::put('/overtimes/{id}/resubmit', [FormController::class,'resubmit']);
    // route/api untuk hr
    Route::prefix('hr')->group(function () {
    Route::get('/users', [UserManagementController::class, 'index']);
    Route::post('/users', [UserManagementController::class, 'store']);
    Route::put('/users/{id}', [UserManagementController::class, 'update']);
    Route::patch('/users/{id}/deactivate', [UserManagementController::class, 'deactivate']);
    Route::patch('/users/{id}/activate', [UserManagementController::class, 'activate']);
    // ambil form ketika/yang ingin edit
    Route::get('/overtimes/{id}', [FormController::class, 'show']);
    });
});

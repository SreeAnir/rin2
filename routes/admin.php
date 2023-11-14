<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
 
Route::middleware('auth:admin')->group(function () {
    // Your admin-only routes go here
    
Route::get('/', [AdminController::class, 'index'])->name('admin.index');
Route::get('users/list', [AdminController::class, 'getUsers'])->name('users.list');
Route::get('notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
Route::post('notifications/store', [NotificationController::class, 'store'])->name('notification.store');


Route::get('notifications', [NotificationController::class, 'index'])->name('admin.notifications');
Route::get('impersonate/{user}', [UserController::class, 'impersonate'])->name('impersonate');
Route::get('admin/notifications/list', [NotificationController::class, 'getAllNotifications'])->name('admin.notification.list');

});

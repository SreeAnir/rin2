<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\OtpController;

use App\Http\Controllers\NotificationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

 
// Route::get('/', function () {
//     return view('welcome');
// })->middleware('auth');

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

Route::middleware('auth:web')->group(function () {
    // Your admin-only routes go here
Route::get('user/notifications', [NotificationController::class, 'index'])->name('user.notifications');
Route::get('notifications/list', [NotificationController::class, 'getNotifications'])->name('notification.list');


Route::get('profile/settings', [ProfileController::class, 'settings'])->name('user.settings');
Route::put('profile/settings', [ProfileController::class, 'updateSettings'])->name('update.user.settings');
Route::post('user/set_read', [UserController::class, 'setRead'])->name('user.set_read');


});



Route::post('/send-otp', [OtpController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify', [OtpController::class, 'verify'])->name('verify.otp');


// Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');


// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::post('/user-logout', [AuthController::class, 'userlogout'])->name('user.logout');
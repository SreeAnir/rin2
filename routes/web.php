<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserController;


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

Route::get('/', [AdminController::class, 'index'])->middleware('auth')->name('admin.index');
Route::get('users/list', [AdminController::class, 'getUsers'])->middleware('auth')->name('users.list');
Route::get('impersonate/{user}', [UserController::class, 'impersonate'])->middleware('auth')->name('impersonate');




// Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');


// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
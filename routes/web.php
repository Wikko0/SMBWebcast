<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Manager\ManagerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes(['verify' => false]);

Route::get('/', [HomeController::class, 'index'])->name('home');


/*
|--------------------------------------------------------------------------
| User Role
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user', [UserController::class, 'dashboard'])->name('user.dashboard');
});


/*
|--------------------------------------------------------------------------
| Admin Role
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| Manager Role
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
});

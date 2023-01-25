<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
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


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
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
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/profile/update', [AdminController::class, 'do_profile'])->name('admin.profile.update');
    Route::post('/admin/profile/changepassword', [AdminController::class, 'do_changepassword'])->name('admin.changepassword');


    Route::get('/admin/manage', [AdminController::class, 'manage_user'])->name('admin.manage_user');
    Route::get('/admin/manage/add', [AdminController::class, 'user_add'])->name('admin.manage_user_add');
    Route::post('/admin/add', [AdminController::class, 'do_user_add'])->name('admin.do_user_add');
    Route::get('/admin/manage/edit/{id}', [AdminController::class, 'user_edit'])->name('admin.manage_user_edit');
    Route::post('/admin/edit', [AdminController::class, 'do_user_edit'])->name('admin.do_user_edit');
    Route::get('/admin/manage/delete/{id}', [AdminController::class, 'user_delete'])->name('admin.manage_user_delete');

    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
});

/*
|--------------------------------------------------------------------------
| Manager Role
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
});

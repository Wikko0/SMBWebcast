<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\PlugnPaidController;
use App\Http\Controllers\PolicyController;

use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
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

/*
|--------------------------------------------------------------------------
| Guests Role
|--------------------------------------------------------------------------
*/

Route::webhooks('webhook');
Auth::routes(
    ['verify' => false,'register' => false,]);
Route::get('/api', [PlugnPaidController::class, 'index']);
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::get('/privacy-policy', [PolicyController::class, 'index']);
Route::post('/join', [JoinController::class, 'join'])->name('join');
Route::get('/room/{meeting_id}', [JoinController::class, 'room'])->name('room');
/*
|--------------------------------------------------------------------------
| User Role
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile/update', [UserController::class, 'do_profile'])->name('user.profile.update');
    Route::post('/user/profile/changepassword', [UserController::class, 'do_changepassword'])->name('user.changepassword');

    Route::get('/user/join', [UserController::class, 'room'])->name('user.room');
    Route::post('/user/join', [UserController::class, 'join'])->name('user.join');
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
    Route::post('/admin/settings', [AdminController::class, 'do_settings'])->name('admin.do_settings');
    Route::get('/admin/email-settings', [AdminController::class, 'emailSettings'])->name('admin.email.settings');
    Route::post('/admin/email-settings', [AdminController::class, 'do_emailSettings'])->name('admin.email.do_settings');
    Route::get('/admin/logo-settings', [AdminController::class, 'logoSettings'])->name('admin.logo.settings');
    Route::post('/admin/logo-settings', [AdminController::class, 'do_logoSettings'])->name('admin.logo.do_settings');
    Route::get('/admin/api-settings', [AdminController::class, 'apiSettings'])->name('admin.api.settings');
    Route::post('/admin/api-settings', [AdminController::class, 'do_apiSettings'])->name('admin.api.do_settings');

    Route::get('/admin/meeting', [AdminController::class, 'meeting'])->name('admin.meeting');
    Route::get('/admin/meeting/history', [AdminController::class, 'meetingHistory'])->name('admin.meeting.history');
    Route::get('/admin/meeting/add', [AdminController::class, 'meeting_add'])->name('admin.meeting_add');
    Route::post('/admin/meeting/add', [AdminController::class, 'do_meeting_add'])->name('admin.do_meeting_add');
    Route::get('/admin/meeting/edit/{id}', [AdminController::class, 'meeting_edit'])->name('admin.meeting_edit');
    Route::post('/admin/meeting/edit', [AdminController::class, 'do_meeting_edit'])->name('admin.do_meeting_edit');
    Route::get('/admin/meeting/delete/{id}', [AdminController::class, 'meeting_delete'])->name('admin.meeting_delete');

    Route::get('/admin/notification', [AdminController::class, 'notificationSettings'])->name('admin.notification');
    Route::post('/admin/notification', [AdminController::class, 'do_notificationSettings'])->name('admin.do_notification');
    Route::get('/admin/send-notification', [AdminController::class, 'notificationSend'])->name('admin.notificationSend');
    Route::post('/admin/send-notification', [AdminController::class, 'do_notificationSend'])->name('admin.do_notificationSend');
});

/*
|--------------------------------------------------------------------------
| Manager Role
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:manager'])->group(function () {

    Route::middleware(['expire'])->group(function () {
        Route::get('/manager/manage/add', [ManagerController::class, 'user_add'])->name('manager.manage_user_add');
        Route::post('/manager/add', [ManagerController::class, 'do_user_add'])->name('manager.do_user_add');
        Route::get('/manager/manage/edit/{id}', [ManagerController::class, 'user_edit'])->name('manager.manage_user_edit');
        Route::post('/manager/edit', [ManagerController::class, 'do_user_edit'])->name('manager.do_user_edit');
        Route::get('/manager/manage/delete/{id}', [ManagerController::class, 'user_delete'])->name('manager.manage_user_delete');

        Route::get('/manager/meeting/add', [ManagerController::class, 'meeting_add'])->name('manager.meeting_add');
        Route::post('/manager/meeting/add', [ManagerController::class, 'do_meeting_add'])->name('manager.do_meeting_add');
        Route::get('/manager/meeting/edit/{id}', [ManagerController::class, 'meeting_edit'])->name('manager.meeting_edit');
        Route::post('/manager/meeting/edit', [ManagerController::class, 'do_meeting_edit'])->name('manager.do_meeting_edit');
        Route::get('/manager/meeting/delete/{id}', [ManagerController::class, 'meeting_delete'])->name('manager.meeting_delete');

    });



    Route::get('/manager', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    Route::get('/manager/profile', [ManagerController::class, 'profile'])->name('manager.profile');
    Route::post('/manager/profile/update', [ManagerController::class, 'do_profile'])->name('manager.profile.update');
    Route::post('/manager/profile/changepassword', [ManagerController::class, 'do_changepassword'])->name('manager.changepassword');


    Route::get('/manager/manage', [ManagerController::class, 'manage_user'])->name('manager.manage_user');


    Route::get('/manager/meeting', [ManagerController::class, 'meeting'])->name('manager.meeting');
     Route::get('/manager/join', [ManagerController::class, 'room'])->name('manager.room');
    Route::post('/manager/join', [ManagerController::class, 'join'])->name('manager.join');
   });

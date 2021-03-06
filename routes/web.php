<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Auth;

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/chart', [DashboardController::class, 'chart']);

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users/list', [UserController::class, 'list']);
        Route::resource('users', UserController::class);
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/profile', ProfileController::class)->name('profile');
        Route::post('/{user}/avatar/update', [FileController::class, 'updateAvatar'])->name('avatar');
    });

    Route::get('/roles/list', [RoleController::class, 'list']);
    Route::resource('roles', RoleController::class);

    Route::get('tickets/list', [TicketController::class, 'list']);
    Route::post('tickets/{ticket}/updateStatus', [TicketController::class, 'updateStatus'])->name('tickets-status.update');
    Route::resource('tickets', TicketController::class);

    Route::get('projects/list', [ProjectController::class, 'list']);
    Route::get('projects/{project}/tickets', [TicketController::class, 'ticketsByProject']);
    Route::resource('projects', ProjectController::class);

    Route::post('/tickets/{ticket}/upload', [FileController::class, 'upload']);
    Route::get('/files/{file}/download', [FileController::class, 'download']);
    Route::delete('/files/{file}', [FileController::class, 'destroy']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/permissions', [UserController::class, 'permissions'])->name('user.permissions');
});

Route::get('/demo', LoginController::class)->name('demo')->middleware(['guest']);
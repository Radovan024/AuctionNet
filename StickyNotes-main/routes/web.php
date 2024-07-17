<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'welcome')->name('welcome');
Route::view('register', 'register')->name('signUp');
Route::view('login', 'login')->name('signIn');

Route::controller(UserController::class)->group(function () {
    Route::post('register', 'createUser')->name('createUser');
    Route::post('login', 'loginUser')->name('loginUser');
    Route::view('profile/{userId}', 'profile')->name('profile');
    Route::post('profile/{userId}', 'updateProfile')->name('update');
    Route::post('logout', 'logout')->name('logout');
});

Route::group(['middleware' => 'access'], function () {
    Route::controller(NoteController::class)->group(function () {
        Route::get('dashboard/{userId}', 'index')->name('dashboard');
        Route::post('create/{userId}', 'createNote')->name('createNote');
        Route::post('update/{noteId}', 'updateNote')->name('updateNote');
        Route::post('delete/{noteId}', 'deleteNote')->name('deleteNote');
    });
});

Route::get('admin', [NoteController::class, 'admin'])
    ->name('adminDashboard')
    ->middleware('can:access-admin');

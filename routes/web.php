<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [Controller::class, 'index'])->name('index');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/tour', [Controller::class, 'tour'])->name('tour');
Route::get('/signup', [AuthController::class, 'signup_show'])->name('signup_show');
Route::get('/signin', [AuthController::class, 'signin_show'])->name('signin_show');

Route::post('/signin', [AuthController::class, 'signin'])->name('signin');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');
Route::get('/home', [Controller::class, 'home'])->name('home');

Route::post('/tour/{tourId}/book', [Controller::class, 'store'])->name('bookings.store');
Route::get('/tour/{id}', [Controller::class, 'show'])->name('tour.show');

//  админка

Route::get('/admin/adminIndex', [AdminController::class, 'adminIndex'])->name('adminIndex');
Route::post('/tours', [AdminController::class, 'Adminstore'])->name('tours.store');
Route::delete('/tours/{tour}', [AdminController::class, 'destroy'])->name('tours.destroy');

Route::get('/admin/AdminApp', [AdminController::class, 'AdminApp'])->name('AdminApp');
Route::put('/admin/changeStatus/{id}', [AdminController::class, 'changeStatus'])->name('admin.changeStatus');

// Route::get('/tours/{tour}/edit', [AdminController::class, 'edit'])->name('tours.edit');
Route::put('/tours/{tour}', [AdminController::class, 'update'])->name('tours.update');

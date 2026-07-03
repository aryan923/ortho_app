<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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

Route::get('/', [HomeController::class, 'index']);

Route::get('/about', [HomeController::class, 'about']);

Route::get('/book-appointment', [HomeController::class, 'BookAppointment']);

Route::get('/doctors', [HomeController::class, 'doctors']);

Route::get('/services', [HomeController::class, 'services']);

Route::get('/blog', [HomeController::class, 'blog']);

Route::get('/register', [AuthController::class, 'viewRegister'])->name('register')->middleware('guest');

Route::post('/register', [AuthController::class, 'register'])->name('register.submit')->middleware('auth');

Route::get('/login', [AuthController::class, 'viewLogin'])->name('login')->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit')->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout.submit')->middleware('auth');

// Route::middleware('auth:sanctum')->group(function () {
//     Route::middleware('ability:issue-access-tokens')->post('/refresh', [Refresh::class, 'refresh']);
   
// });

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');

Route::get('/count-users', [DashboardController::class, 'countUsers'])->name('count-users')->middleware('auth');

Route::get('/get-users', [DashboardController::class, 'getUsers'])->name('get-users')->middleware('auth');

Route::get('/view-users', [DashboardController::class, 'viewUsers'])->name('view-users')->middleware('auth');

Route::put('/users/{id}', [DashboardController::class, 'updateUser'])->name('users.update')->middleware('auth');

Route::get('/search-users', [DashboardController::class, 'searchUsers'])->name('userSearch')->middleware('auth');

Route::delete('/delete-user/{id}', [DashboardController::class, 'deleteUser'])->name('users.delete')->middleware('auth');
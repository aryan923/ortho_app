<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnquiryController;

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

Route::get('/book-appointment', [HomeController::class, 'BookAppointment'])->name('book-appointment');

Route::get('/doctors', [HomeController::class, 'doctors']);

Route::get('/services', [HomeController::class, 'services']);

// Auth Routes

Route::get('/register', [AuthController::class, 'viewRegister'])->name('register')->middleware('guest');

Route::post('/register', [AuthController::class, 'register'])->name('register.submit')->middleware('guest');

Route::get('/login', [AuthController::class, 'viewLogin'])->name('login')->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit')->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout.submit')->middleware('auth');

// Route::middleware('auth:sanctum')->group(function () {
//     Route::middleware('ability:issue-access-tokens')->post('/refresh', [Refresh::class, 'refresh']);
   
// });

// Admin Routes-User Management

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/count-users', [DashboardController::class, 'countUsers'])->name('count-users')->middleware('permission:getUsers');
    Route::get('/get-users', [DashboardController::class, 'getUsers'])->name('get-users')->middleware('permission:getUsers');
    Route::get('/view-users', [DashboardController::class, 'viewUsers'])->name('view-users')->middleware('permission:getUsers');
    Route::put('/users/{id}', [DashboardController::class, 'updateUser'])->name('users.update')->middleware('permission:editUsers');
    Route::get('/search-users', [DashboardController::class, 'searchUsers'])->name('userSearch')->middleware('permission:getUsers');
    Route::delete('/delete-user/{id}', [DashboardController::class, 'deleteUser'])->name('users.delete')->middleware('permission:deleteUsers');

    // Admin Routes-Role Management
    Route::post('/create-role', [DashboardController::class, 'createRole'])->name('create-role')->middleware('permission:createRoles');
    Route::put('/edit-role/{id}', [DashboardController::class, 'editRole'])->name('edit-role')->middleware('permission:editRoles');
    Route::delete('/delete-role/{id}', [DashboardController::class, 'deleteRole'])->name('delete-role')->middleware('permission:deleteRoles');
    Route::get('/roles', [DashboardController::class, 'Roles'])->name('roles')->middleware('permission:viewRoles');
    Route::get('/get-roles', [DashboardController::class, 'getRoles'])->name('get-roles')->middleware('permission:viewRoles');
    Route::get('/get-role-options', [DashboardController::class, 'getRoleOptions'])->name('get-role-options')->middleware('permission:viewRoles');
    Route::get('/get-permissions', [DashboardController::class, 'getPermissions'])->name('get-permissions')->middleware('permission:viewRoles');

    Route::get('/admin/settings', [App\Http\Controllers\admin\SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/admin/settings', [App\Http\Controllers\admin\SettingsController::class, 'update'])->name('admin.settings.update');
    Route::get('/admin/cms', [App\Http\Controllers\admin\PageContentController::class, 'index'])->name('admin.cms');
    Route::get('/admin/cms/{page}', [App\Http\Controllers\admin\PageContentController::class, 'edit'])->name('admin.cms.edit');
    Route::post('/admin/cms/{page}', [App\Http\Controllers\admin\PageContentController::class, 'update'])->name('admin.cms.update');

    Route::get('/admin/blogs', [App\Http\Controllers\admin\BlogController::class, 'index'])->name('admin.blogs.index');
    Route::get('/admin/blogs/create', [App\Http\Controllers\admin\BlogController::class, 'create'])->name('admin.blogs.create');
    Route::post('/admin/blogs', [App\Http\Controllers\admin\BlogController::class, 'store'])->name('admin.blogs.store');
    Route::get('/admin/blogs/{blog}/edit', [App\Http\Controllers\admin\BlogController::class, 'edit'])->name('admin.blogs.edit');
    Route::put('/admin/blogs/{blog}', [App\Http\Controllers\admin\BlogController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/admin/blogs/{blog}', [App\Http\Controllers\admin\BlogController::class, 'destroy'])->name('admin.blogs.destroy');
});

Route::get('/blog', [App\Http\Controllers\HomeController::class, 'blog'])->name('blog');
Route::get('/blog/{blog}', [App\Http\Controllers\HomeController::class, 'showBlog'])->name('blog.show');

Route::middleware('auth')->group(function () {
    Route::post('/doctors/{doctor}/bookings', [BookingController::class, 'create'])->name('doctor.bookings.store');
    Route::get('/doctors/{doctor}/booked-slots', [BookingController::class, 'getBookedSlots'])->name('doctor.booked-slots');
});

Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', [App\Http\Controllers\doctor\DashboardController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/bookings', [App\Http\Controllers\doctor\DashboardController::class, 'getBookings'])->name('doctor.bookings');
});

Route::get('/doctor/schedule', [DoctorScheduleController::class, 'index'])->name('doctor.schedule');
Route::get('/doctors/{doctor}/schedule', [DoctorScheduleController::class, 'show'])->name('doctor.view.schedule');

// Enquiry Routes
Route::post('/enquiries', [EnquiryController::class, 'store'])->name('enquiries.store');

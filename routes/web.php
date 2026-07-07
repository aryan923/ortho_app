<?php

use App\Http\Controllers\admin\DashboardController;
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

Route::get('/book-appointment', [HomeController::class, 'BookAppointment']);

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

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');

Route::get('/count-users', [DashboardController::class, 'countUsers'])->name('count-users')->middleware(['auth', 'permission:getUsers']);

Route::get('/get-users', [DashboardController::class, 'getUsers'])->name('get-users')->middleware(['auth', 'permission:getUsers']);

Route::get('/view-users', [DashboardController::class, 'viewUsers'])->name('view-users')->middleware(['auth', 'permission:getUsers']);

Route::put('/users/{id}', [DashboardController::class, 'updateUser'])->name('users.update')->middleware(['auth', 'permission:editUsers']);

Route::get('/search-users', [DashboardController::class, 'searchUsers'])->name('userSearch')->middleware(['auth', 'permission:getUsers']);

Route::delete('/delete-user/{id}', [DashboardController::class, 'deleteUser'])->name('users.delete')->middleware(['auth', 'permission:deleteUsers']);

// Admin Routes-Role Management

Route::post('/create-role', [DashboardController::class, 'createRole'])->name('create-role')->middleware(['auth', 'permission:createRoles']);

Route::put('/edit-role/{id}', [DashboardController::class, 'editRole'])->name('edit-role')->middleware(['auth', 'permission:editRoles']);

Route::delete('/delete-role/{id}', [DashboardController::class, 'deleteRole'])->name('delete-role')->middleware(['auth', 'permission:deleteRoles']);

Route::get('/roles', [DashboardController::class, 'Roles'])->name('roles')->middleware(['auth', 'permission:viewRoles']);

Route::get('/get-roles', [DashboardController::class, 'getRoles'])->name('get-roles')->middleware(['auth', 'permission:viewRoles']);
Route::get('/get-role-options', [DashboardController::class, 'getRoleOptions'])->name('get-role-options')->middleware(['auth', 'permission:viewRoles']);

Route::get('/get-permissions', [DashboardController::class, 'getPermissions'])->name('get-permissions')->middleware(['auth', 'permission:viewRoles']);

Route::get('/admin/settings', [App\Http\Controllers\admin\SettingsController::class, 'index'])->name('admin.settings')->middleware('auth');
Route::post('/admin/settings', [App\Http\Controllers\admin\SettingsController::class, 'update'])->name('admin.settings.update')->middleware('auth');
Route::get('/admin/cms', [App\Http\Controllers\admin\PageContentController::class, 'index'])->name('admin.cms')->middleware('auth');
Route::get('/admin/cms/{page}', [App\Http\Controllers\admin\PageContentController::class, 'edit'])->name('admin.cms.edit')->middleware('auth');
Route::post('/admin/cms/{page}', [App\Http\Controllers\admin\PageContentController::class, 'update'])->name('admin.cms.update')->middleware('auth');

Route::get('/admin/blogs', [App\Http\Controllers\admin\BlogController::class, 'index'])->name('admin.blogs.index')->middleware('auth');
Route::get('/admin/blogs/create', [App\Http\Controllers\admin\BlogController::class, 'create'])->name('admin.blogs.create')->middleware('auth');
Route::post('/admin/blogs', [App\Http\Controllers\admin\BlogController::class, 'store'])->name('admin.blogs.store')->middleware('auth');
Route::get('/admin/blogs/{blog}/edit', [App\Http\Controllers\admin\BlogController::class, 'edit'])->name('admin.blogs.edit')->middleware('auth');
Route::put('/admin/blogs/{blog}', [App\Http\Controllers\admin\BlogController::class, 'update'])->name('admin.blogs.update')->middleware('auth');
Route::delete('/admin/blogs/{blog}', [App\Http\Controllers\admin\BlogController::class, 'destroy'])->name('admin.blogs.destroy')->middleware('auth');

Route::get('/blog', [App\Http\Controllers\HomeController::class, 'blog'])->name('blog');
Route::get('/blog/{blog}', [App\Http\Controllers\HomeController::class, 'showBlog'])->name('blog.show');

// Enquiry Routes
Route::post('/enquiries', [EnquiryController::class, 'store'])->name('enquiries.store');

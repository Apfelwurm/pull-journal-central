<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganisationController;
use App\Http\Middleware\SuperAdmin;
use App\Http\Middleware\DeviceAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth', 'role:viewer|deviceadmin|superadmin')->group(function () {
    Route::resource('/devices', DeviceController::class)->only('index');
});

Route::middleware('auth', 'role:deviceadmin|superadmin')->group(function () {
    Route::get('/devices/verify/{device}', [DeviceController::class, 'verify'])->name('devices.verify');
    Route::get('/devices/unverify/{device}', [DeviceController::class, 'unverify'])->name('devices.unverify');
});


Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resource('/users', UserController::class)->except('show');
    Route::resource('/devices', DeviceController::class)->except('index');
    Route::resource('/organisations', OrganisationController::class);
});





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/users/{User}', [UserController::class, 'show'])->name('users.show');

});




// Route::middleware(['auth', 'viewer'])->group(function () {
//     Route::get('/devices', [ProfileController::class, 'edit'])->name('devices.show');
//     // Route::get('/devices/{device}/logs', [ProfileController::class, 'edit'])->name('devices.logs.show');
// });

require __DIR__.'/auth.php';

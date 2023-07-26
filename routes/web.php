<?php

use App\Http\Controllers\DeviceController;
use App\Http\Controllers\LogEntryController;
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
        'canRegister' => Route::has('register')
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard',[
        'BUILDNUMBER' => env('BUILDNUMBER', 'dev'),
        'BUILDID' => env('BUILDID', 'dev'),
        'SOURCE_COMMIT' => env('SOURCE_COMMIT', 'dev'),
        'BUILDNODE' => env('BUILDNODE', 'dev'),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth', 'role:viewer|deviceadmin|superadmin')->group(function () {
    Route::resource('/devices', DeviceController::class)->only('index');
    Route::resource('/logEntries', LogEntryController::class)->only(['index', 'show']);
});

Route::middleware('auth', 'role:deviceadmin|superadmin')->group(function () {
    Route::resource('/devices', DeviceController::class)->except(['index']);
    Route::get('/devices/verify/{device}', [DeviceController::class, 'verify'])->name('devices.verify');
    Route::get('/devices/unverify/{device}', [DeviceController::class, 'unverify'])->name('devices.unverify');
    Route::get('/logEntries/aknowledge/{logEntry}', [LogEntryController::class, 'aknowledge'])->name('logEntries.aknowledge');
    Route::get('/logEntries/unaknowledge/{logEntry}', [LogEntryController::class, 'unaknowledge'])
                ->name('logEntries.unaknowledge');
});


Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::resource('/users', UserController::class)->except('show');
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

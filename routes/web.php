<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomtypeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffPaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CheckInController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\AccountController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/
Route::get('/admin/login',  [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'loginPost'])->name('admin.login.post');
Route::post('/admin/logout',[AdminController::class, 'logout'])->name('admin.logout');

// Fix: Authenticate middleware looks for a 'login' named route — point it to admin login
Route::get('/login', fn() => redirect()->route('admin.login'))->name('login');

/*
|--------------------------------------------------------------------------
| Admin Protected Area
|--------------------------------------------------------------------------
*/
Route::middleware('auth:admin')->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard',        [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/report', [DashboardController::class, 'report'])->name('admin.dashboard.report');

    // Search
    Route::get('search', [SearchController::class, 'index'])->name('admin.search');

    // Account
    Route::get('profile',           [AccountController::class, 'profile'])->name('admin.profile');
    Route::put('profile',           [AccountController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('settings',          [AccountController::class, 'settings'])->name('admin.settings');
    Route::put('settings/password', [AccountController::class, 'updatePassword'])->name('admin.settings.password');

    // Bookings & Check-ins
    Route::get ('bookings',                    [BookingController::class, 'index'])->name('bookings.index');
    Route::get ('bookings/create',             [BookingController::class, 'create'])->name('bookings.create');
    Route::post('bookings',                    [BookingController::class, 'store'])->name('bookings.store');
    Route::get ('bookings/{booking}/checkout', [BookingController::class, 'checkoutForm'])->name('bookings.checkout');
    Route::post('bookings/{booking}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout.process');
    Route::get ('bookings/{booking}',          [BookingController::class, 'show'])->name('bookings.show');
    Route::get ('bookings/check-availability', [BookingController::class, 'checkAvailability'])->name('bookings.checkAvailability');

    Route::get ('check-ins',        [CheckInController::class, 'index'])->name('checkins.index');
    Route::get ('check-ins/create', [CheckInController::class, 'create'])->name('checkins.create');
    Route::post('check-ins',        [CheckInController::class, 'store'])->name('checkins.store');

    // Resources
    Route::resource('roomtypes',   RoomtypeController::class);
    Route::resource('rooms',       RoomController::class);
    Route::resource('customers',   CustomerController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('staff',       StaffController::class);

    /*
    |----------------------------------------------------------------------
    | Staff Payments
    |----------------------------------------------------------------------
    */

    Route::get('staff-payments/summary', [StaffPaymentController::class, 'summary'])->name('staff.payments.summary');

    // All payments index + create/store
    Route::get ('staff-payments',         [StaffPaymentController::class, 'index'])->name('staff.payments.index');
    Route::get ('staff-payments/create',  [StaffPaymentController::class, 'create'])->name('staff.payments.create');
    Route::post('staff-payments',         [StaffPaymentController::class, 'store'])->name('staff.payments.store');

    // Edit / update / delete a single payment
    Route::get   ('staff-payments/{payment}/edit', [StaffPaymentController::class, 'edit'])->name('staff.payments.edit');
    Route::put   ('staff-payments/{payment}',      [StaffPaymentController::class, 'update'])->name('staff.payments.update');
    Route::delete('staff-payments/{payment}',      [StaffPaymentController::class, 'destroy'])->name('staff.payments.destroy');

    // Per-staff payment history
    Route::get('staff/{staff}/payments', [StaffPaymentController::class, 'history'])->name('staff.payments.history');

});
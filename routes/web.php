<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('patient', PatientController::class);
    Route::resource('appointment', AppointmentController::class);
    Route::resource('user', UserController::class);
    Route::resource('role', RoleController::class);
    Route::resource('payment', PaymentController::class);
    Route::resource('doctor', DoctorController::class);
    Route::resource('invoice', InvoiceController::class);
    Route::resource('availability', AvailabilityController::class);
});

Route::post('/change-language', [LanguageController::class, 'switchLang'])->name('change-language');
Route::get('/payment/{id}/print', [PaymentController::class, 'print'])->name('payment.print');

require __DIR__ . '/auth.php';
// routes/web.php

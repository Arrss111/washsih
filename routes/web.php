<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

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
});

require __DIR__.'/auth.php';


Route::middleware(['auth'])->group(function () {
    Route::get('/booking/step1', [BookingController::class, 'step1'])->name('booking.step1');
    Route::post('/booking/step1', [BookingController::class, 'storeStep1']);
    
    Route::get('/booking/step2', [BookingController::class, 'step2'])->name('booking.step2');
    Route::post('/booking/step2', [BookingController::class, 'storeStep2']);
    
    Route::get('/booking/step3', [BookingController::class, 'step3'])->name('booking.step3');
    Route::post('/booking/step3', [BookingController::class, 'storeStep3']);
    
    Route::get('/booking/success', [BookingController::class, 'success'])->name('booking.success');

    // Untuk AJAX cek waktu
    Route::get('/available-times', [BookingController::class, 'availableTimes']);
});


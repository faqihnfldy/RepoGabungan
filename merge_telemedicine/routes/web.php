<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Doctor\DoctorScheduleController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\Admin\HealthReminderController;
use App\Http\Controllers\ChatController;

// Home
Route::get('/', function () {
    return view('dashboard');
})->name('home');

// Routes for Authentication
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {

    // Chat Routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/messages/{userId}', [ChatController::class, 'getMessages'])->name('chat.messages');

    // Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // Health Reminder Routes
        Route::resource('health-reminder', HealthReminderController::class, [
            'as' => 'admin',
            'prefix' => 'admin'
        ]);

        // Appointment Status Update
        Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])
            ->name('appointments.update-status');
    });

    // Patient (User) Routes
    Route::middleware('role:user')->group(function () {
        Route::get('/pasien/dashboard', function () {
            return view('pasien.dashboard');
        })->name('pasien.dashboard');

        Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('/appointments/history', [AppointmentController::class, 'history'])->name('appointments.history');
    });

    // Doctor Routes
    Route::middleware('role:doctor')->group(function () {
        Route::get('/doctor/dashboard', function () {
            return view('doctor.dashboard');
        })->name('doctor.dashboard');

        Route::get('/doctor/schedule', [DoctorScheduleController::class, 'index'])->name('doctor.schedule');
        Route::get('/doctor/schedule/create', [DoctorScheduleController::class, 'create'])->name('doctor.schedule.create');
        Route::post('/doctor/schedule', [DoctorScheduleController::class, 'store'])->name('doctor.schedule.store');
        Route::delete('/doctor/schedule/{schedule}', [DoctorScheduleController::class, 'destroy'])->name('doctor.schedule.destroy');
        
        // Tambahkan route untuk riwayat janji temu dokter
        Route::get('/doctor/appointments/history', [AppointmentController::class, 'doctorHistory'])->name('doctor.appointments.history');
    });

    // Common Appointment Routes (semua user yang login)
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
});

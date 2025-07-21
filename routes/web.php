<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TherapistController;
use App\Http\Controllers\TreatmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackupController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return redirect('/assignments');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
    Route::get('/backup/run', [BackupController::class, 'run'])->name('backup.run');
    Route::get('/backup/download', [BackupController::class, 'download'])->name('backup.download');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/assignments/cancelled', [AssignmentController::class, 'cancelledAssignments'])->name('assignments.cancelled');

    Route::get('/therapists/therapistslist', [TherapistController::class, 'therapistslist'])->name('therapists.therapistslist');

    Route::resource('rooms', RoomController::class);
    Route::resource('therapists', TherapistController::class);
    Route::resource('treatments', TreatmentController::class);
    Route::resource('assignments', AssignmentController::class);
    Route::resource('guests', GuestController::class);

    Route::patch('/therapists/{therapist}/toggle', [TherapistController::class, 'toggle'])->name('therapists.toggle');
    


});

require __DIR__.'/auth.php';

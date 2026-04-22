<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function () {
    return view('login');
})->name('login');

Route::post('login', [App\Http\Controllers\UserController::class, 'makeLogin'])->name('login.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');

    Route::resource('users', App\Http\Controllers\UserController::class);
    
    // Master Module start
    Route::resource('clients', App\Http\Controllers\ClientsController::class);
    Route::resource('mocs', App\Http\Controllers\MOCController::class);
    Route::resource('flanges', App\Http\Controllers\FlangeController::class);
    Route::resource('capillaries', App\Http\Controllers\CapillaryController::class);
    // Master Module end

    // Operation Module start
    Route::resource('jobcards', App\Http\Controllers\JobcardController::class);
    Route::resource('inspections', App\Http\Controllers\InspectionController::class);
    Route::resource('oil-fillings', App\Http\Controllers\OilFillingController::class);
    Route::resource('calibrations', App\Http\Controllers\CalibrationController::class);

    Route::get('/certificate/{id}/', [App\Http\Controllers\CertificateController::class, 'generateJobCertificate'])->name('jobcards.certificate');
});

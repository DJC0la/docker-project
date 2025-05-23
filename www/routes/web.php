<?php

use App\Http\Controllers\{ProfileController, UserController, OrganizationController,
    ContactController, DirectionController, ProgramController};
use Illuminate\Support\Facades\Route;
use App\Enums\TypesRole;

Route::get('/', fn () => view('welcome'));

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    Route::get('/organization', [OrganizationController::class, 'index'])->name('organization');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::get('/direction', [DirectionController::class, 'index'])->name('direction');
    Route::get('/program', [ProgramController::class, 'index'])->name('program');
});

Route::middleware(['auth', 'role:'.TypesRole::ADMIN->value])->group(function () {
    Route::resource('users', UserController::class)->except(['index', 'create', 'show']);

    Route::controller(OrganizationController::class)->prefix('organization')->group(function () {
        Route::post('/', 'store')->name('organization.store');
        Route::put('/{organization}', 'update')->name('organization.update');
        Route::delete('/{organization}', 'destroy')->name('organization.destroy');
    });

    Route::controller(ContactController::class)->prefix('contact')->group(function () {
        Route::post('/', 'store')->name('contact.store');
        Route::put('/{contact}', 'update')->name('contact.update');
        Route::delete('/{contact}', 'destroy')->name('contact.destroy');
    });

    Route::controller(DirectionController::class)->prefix('direction')->group(function () {
        Route::post('/', 'store')->name('direction.store');
        Route::put('/{direction}', 'update')->name('direction.update');
        Route::delete('/{direction}', 'destroy')->name('direction.destroy');
    });

    Route::controller(ProgramController::class)->prefix('program')->group(function () {
        Route::post('/', 'store')->name('program.store');
        Route::put('/{program}', 'update')->name('program.update');
        Route::delete('/{program}', 'destroy')->name('program.destroy');
    });
});

require __DIR__.'/auth.php';

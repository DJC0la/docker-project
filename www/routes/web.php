<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Enums\TypesRole;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/organization', [OrganizationController::class, 'index'])->name('organization');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
});

Route::middleware(['auth', 'role:'.TypesRole::ADMIN->value])->group(function () {
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::post('/organization', [OrganizationController::class, 'store'])->name('organization.store');
    Route::put('/organization/{organization}', [OrganizationController::class, 'update'])->name('organization.update');
    Route::delete('/organization/{organization}', [OrganizationController::class, 'destroy'])->name('organization.destroy');

    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::put('/contact/{contact}', [ContactController::class, 'update'])->name('contact.update');
    Route::delete('/contact/{contact}', [ContactController::class, 'destroy'])->name('contact.destroy');
});

require __DIR__.'/auth.php';

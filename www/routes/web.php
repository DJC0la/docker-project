<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\DirectionController;
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
    Route::get('/direction', [DirectionController::class, 'index'])->name('direction');
});

Route::middleware(['auth', 'role:'.TypesRole::ADMIN->value])->group(function () {
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::post('/organization', [OrganizationController::class, 'store'])->name('organization.store');
    Route::put('/organization/{organization}', [OrganizationController::class, 'update'])->name('organization.update');
    Route::delete('/organization/{organization}', [OrganizationController::class, 'destroy'])->name('organization.destroy');

    Route::post('/direction', [DirectionController::class, 'store'])->name('direction.store');
    Route::put('/direction/{direction}', [DirectionController::class, 'update'])->name('direction.update');
    Route::delete('/direction/{direction}', [DirectionController::class, 'destroy'])->name('direction.destroy');
});

require __DIR__.'/auth.php';

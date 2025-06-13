<?php

use App\Http\Controllers\AnggotaController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Spatie\Permission\Models\Role;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/anggota', [AnggotaController::class, 'anggotaList'])
    ->middleware('role:admin')
    ->name('list-anggota');

Route::post('save-anggota', ['middleware' => ['role:admin']], [AnggotaController::class, 'anggotaSave'])->name('save-anggota');

require __DIR__.'/auth.php';

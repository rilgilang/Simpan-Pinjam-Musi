<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\SimpananController;
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

Route::get('/simpanan', [SimpananController::class, 'simpananList'])
    ->middleware(['auth', 'verified'])
    ->name('list-simpanan');

Route::get('/pinjaman', [PinjamanController::class, 'pinjamanList'])
    ->middleware(['auth', 'verified'])
    ->name('list-pinjaman');

Route::post('pengajuan-pinjaman', [PinjamanController::class, 'pengajuanPinjaman'])
    ->middleware(['role:anggota'])
    ->name('pengajuan-pinjaman');

// Route::get('/anggota/:id', [AnggotaController::class, 'anggotaDetail'])
//     ->middleware(['role:anggota|admin'])
//     ->name('anggota-detail');

Route::get('/anggota/{id}', [AnggotaController::class, 'anggotaDetail'])
    ->middleware(['role:admin'])
    ->name('anggota-detail');

Route::post('save-anggota', [AnggotaController::class, 'anggotaSave'])
    ->middleware(['role:admin'])
    ->name('save-anggota');

Route::post('save-simpanan', [SimpananController::class, 'simpananSave'])
    ->middleware(['role:admin'])
    ->name('save-simpanan');
    
require __DIR__.'/auth.php';

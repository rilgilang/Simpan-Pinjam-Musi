<?php

use App\Http\Controllers\AdminController;
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

Route::get('/admin', [AdminController::class, 'adminList'])
    ->middleware('role:ketua')
    ->name('list-admin');

Route::get('/anggota', [AnggotaController::class, 'anggotaList'])
    ->middleware('role:admin')
    ->name('list-anggota');

Route::get('/simpanan', [SimpananController::class, 'simpananList'])
    ->middleware(['auth', 'verified'])
    ->name('list-simpanan');

Route::get('/pinjaman', [PinjamanController::class, 'pinjamanList'])
    ->middleware(['auth', 'verified'])
    ->name('list-pinjaman');

Route::get('/pinjaman/{pinjaman_id}', [PinjamanController::class, 'pinjamanDetail'])
    ->middleware(['auth', 'verified'])
    ->name('detail-pinjaman');

Route::get('/pinjaman/{pinjaman_id}', [PinjamanController::class, 'pinjamanDetail'])
    ->middleware(['auth', 'verified'])
    ->name('detail-pinjaman');

Route::patch('/update-angsuran/{ud}', [PinjamanController::class, 'updateAngsuran'])
    ->middleware(['role:admin'])
    ->name('update-angsuran');

Route::get('/approve-pengajuan/{id}', [PinjamanController::class, 'approvePengajuanPinjaman'])
        ->middleware(['role:ketua|admin'])
    ->name('approve-pengajuan-pinjaman');

Route::get('/reject-pengajuan/{id}', [PinjamanController::class, 'pengajuanPinjamanList'])
        ->middleware(['role:ketua|admin'])
    ->name('reject-pengajuan-pinjaman');

Route::post('pengajuan-pinjaman', [PinjamanController::class, 'pengajuanPinjaman'])
    ->middleware(['role:anggota'])
    ->name('pengajuan-pinjaman');

Route::get('/anggota/{id}', [AnggotaController::class, 'anggotaDetail'])
    ->middleware(['role:admin'])
    ->name('anggota-detail');

Route::post('save-anggota', [AnggotaController::class, 'anggotaSave'])
    ->middleware(['role:admin'])
    ->name('save-anggota');

Route::post('save-admin', [AdminController::class, 'adminSave'])
    ->middleware(['role:ketua'])
    ->name('save-admin');

Route::get('/delete-admin/{id}', [AdminController::class, 'adminDelete'])
    ->middleware(['role:ketua'])
    ->name('admin-delete');

Route::post('save-simpanan', [SimpananController::class, 'simpananSave'])
    ->middleware(['role:admin'])
    ->name('save-simpanan');
    
require __DIR__.'/auth.php';

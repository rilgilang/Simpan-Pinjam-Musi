<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\SahamController;
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

Route::get('/pinjaman/export', [PinjamanController::class, 'exportPinjamanToPdf'])
    ->middleware(['role:admin|ketua'])
    ->name('export-pinjaman');

Route::get('/simpanan/export', [SimpananController::class, 'exportSimpananToPdf'])
    ->middleware(['role:admin|ketua'])
    ->name('export-simpanan');

Route::get('/pinjaman/{pinjaman_id}', [PinjamanController::class, 'pinjamanDetail'])
    ->middleware(['auth', 'verified'])
    ->name('detail-pinjaman');

Route::patch('/update-angsuran/{id}', [PinjamanController::class, 'updateAngsuran'])
    ->middleware(['role:admin'])
    ->name('update-angsuran');

Route::get('/approve-pengajuan/{id}', [PinjamanController::class, 'approvePengajuanPinjaman'])
        ->middleware(['role:ketua|admin'])
    ->name('approve-pengajuan-pinjaman');

Route::post('/reject-pengajuan', [PinjamanController::class, 'rejectPengajuanPinjaman'])
        ->middleware(['role:ketua|admin'])
    ->name('reject-pengajuan-pinjaman');

Route::post('pengajuan-pinjaman', [PinjamanController::class, 'pengajuanPinjaman'])
    ->middleware(['role:anggota'])
    ->name('pengajuan-pinjaman');

Route::get('pengajuan-pinjaman-list', [PinjamanController::class, 'pengajuanPinjamanList'])
    ->middleware(['auth', 'verified'])
    ->name('pengajuan-pinjaman-list');

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

Route::post('update-simpanan', [SimpananController::class, 'simpananUpdate'])
    ->middleware(['role:admin'])
    ->name('update-simpanan');    

Route::post('delete-simpanan', [SimpananController::class, 'simpananDelete'])
    ->middleware(['role:admin'])
    ->name('delete-simpanan');    

Route::get('/shu', [PinjamanController::class, 'shuList'])
    ->middleware(['role:admin|ketua'])
    ->name('shu-list');

Route::get('/index-saham', [SahamController::class, 'indexSahamList'])
    ->middleware(['role:admin|ketua'])
    ->name('saham-list');

Route::post('save-index-saham', [SahamController::class, 'indexSahamSave'])
    ->middleware(['role:admin|ketua'])
    ->name('save-index-saham');

Route::post('update-index-saham', [SahamController::class, 'updateSaham'])
        ->middleware(['role:ketua|admin'])
    ->name('update-index-saham');

require __DIR__.'/auth.php';

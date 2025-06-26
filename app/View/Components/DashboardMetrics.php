<?php

namespace App\View\Components;

use App\Models\Anggota;
use App\Models\PengajuanPinjaman;
use App\Models\Pinjaman;
use App\Models\Simpanan;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class DashboardMetrics extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        $result = [];

        $user = Auth::user();

        if ($user->hasRole("admin") || $user->hasRole("ketua")) {
            // 1. Total Anggota Aktif & Non-Aktif
            $totalAnggotaAktif = Anggota::where('status', 'aktif')->count();
            $totalAnggotaNonAktif = Anggota::where('status', 'non-aktif')->count();


            // 2. Pinjaman Aktif
            $pinjamanAktif = Pinjaman::where('status', 'aktif')->count();

            // 3. Pengajuan Menunggu Persetujuan
            $pengajuanPending = PengajuanPinjaman::where(function ($q) {
                $q->where('status_persetujuan_admin', 'menunggu')
                ->orWhere('status_persetujuan_ketua', 'menunggu');
            })->count();

            $result = [
                'total_anggota_aktif' => $totalAnggotaAktif,
                'total_anggota_non_aktif' => $totalAnggotaNonAktif,
                'pinjaman_aktif' =>  $pinjamanAktif,
                'pengajuan_pending' =>  $pengajuanPending,
            ];
        }
        else {

            $userId = Auth::id(); // Get the current user's ID

            // anggota
            $simpanan = Simpanan::join('anggota', 'anggota.id', '=', 'simpanan.id_anggota')
                ->join('users', 'users.id', '=', 'anggota.id_user')
                ->where('users.id', '=', $userId)
                ->sum('simpanan.jumlah');

            $pinjaman = Pinjaman::join('anggota', 'anggota.id', '=', 'pinjaman.id_anggota')
                ->join('users', 'users.id', '=', 'anggota.id_user')
                ->where('users.id', '=', $userId)
                ->count();

            $result['simpanan'] = $simpanan;
            $result['pinjaman'] = $pinjaman;
        }

            return view('components.dashboard-metrics', ['result' => $result]);
    }
}

<?php

namespace App\View\Components;

use App\Models\Pinjaman;
use App\Models\Simpanan;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardTransactionThisMonth extends Component
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
        // Komposisi Dana Bulan Ini (SUM Simpanan vs SUM Pinjaman)
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $totalSimpanan = Simpanan::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('jumlah');

        $totalPinjaman = Pinjaman::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('jumlah_pinjaman');


        return view('components.dashboard-transaction-this-month',  [
            'simpanan' => $totalSimpanan,
            'pinjaman' => $totalPinjaman,
        ]);
    }
}

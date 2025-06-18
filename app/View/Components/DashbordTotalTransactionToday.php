<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class DashboradTotalTransactionToday extends Component
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

            $todayTotal = DB::table('histori_simpanan')
            ->whereDate('created_at', now()->toDateString())
            ->sum('jumlah');

            $historicalAvg = DB::table('histori_simpanan')
                ->selectRaw('DATE(created_at) as tanggal, SUM(jumlah) as total')
                ->groupBy(DB::raw('DATE(created_at)'))
                ->pluck('total')
                ->avg();

            $progress = $historicalAvg > 0 ? ($todayTotal / $historicalAvg) * 100 : 0;

        return view('components.dashborad-total-transaction-today', ['today_total' => $todayTotal, 'historical_avg' => $historicalAvg, 'progress_percent' => round($progress, 2)]);
    }
}

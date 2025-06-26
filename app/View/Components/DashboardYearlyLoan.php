<?php

namespace App\View\Components;

use App\Models\Pinjaman;
use App\Models\Simpanan;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class DashboardYearlyLoan extends Component
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


$currentYear = Carbon::now()->year;

        // Get totals grouped by month
        $monthly = Pinjaman::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(jumlah_pinjaman) as total')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month'); // returns [12 => 1000000, ...]

        $result = [];

        // Loop through months Jan to Dec
        for ($month = 1; $month <= 12; $month++) {
            $result[] = $monthly[$month] ?? 0;
        }
        return view('components.dashboard-yearly-loan', ['result' =>  $result]);
    }
}

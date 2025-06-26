<?php

namespace App\View\Components;

use App\Models\Simpanan;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class DashboardYearlySaving extends Component
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

            // Get actual monthly totals from DB
            $monthlyTotals = Simpanan::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(jumlah) as total')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month'); // e.g. [12 => 3000000]

            // Ensure all 12 months are present, filling missing ones with 0
            $result = [];
            for ($month = 1; $month <= 12; $month++) {
                $result[] = $monthlyTotals[$month] ?? 0;
            }

        return view('components.dashboard-yearly-saving', [
                'result' => $result,
        ]);
    }
}
<?php

namespace App\View\Components;

use App\Models\Angsuran;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class CurrentInstallment extends Component
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
        $userId = Auth::id();

        $angsuran = Angsuran::join('pinjaman', 'pinjaman.id', '=', 'angsuran.id_pinjaman')
            ->join('anggota', 'anggota.id', '=', 'pinjaman.id_anggota')
            ->join('users', 'users.id', '=', 'anggota.id_user') // Correct table name is usually `users`
            ->select('angsuran.pembayaran_ke', 'angsuran.status')
            ->where('users.id', $userId)
            ->orderBy('pinjaman.created_at', 'desc')
            ->orderBy('angsuran.pembayaran_ke', 'desc')
            ->get();


        return view('components.current-installment', ['angsuranList' => $angsuran]);
    }
}

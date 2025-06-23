<?php

namespace App\View\Components;

use App\Models\Pinjaman;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class CurrentLoan extends Component
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

        $pinjaman = Pinjaman::join('anggota', 'anggota.id', '=', 'pinjaman.id_anggota')
            ->join('users', 'users.id', '=', 'anggota.id_user')
            ->where('users.id', $userId)
            ->orderBy('pinjaman.created_at', 'desc')
            ->limit(1)
            ->first(); // <-- this is required to actually get the result


        return view('components.current-loan', ['currentLoan' => $pinjaman]);
    }
}

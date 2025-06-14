<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PinjamanController extends Controller
{
    public function pinjamanList(): View{

        $pinjaman = Pinjaman::join('anggota', 'anggota.id', '=', 'pinjaman.id_anggota')
        ->join('users', 'anggota.id_user', '=', 'users.id')
        ->select('users.id', 'users.name', 'pinjaman.id_anggota', 'pinjaman.jumlah_pinjaman', 'pinjaman.created_at')
        ->get();
        
    return view('pinjaman/pinjaman-list', ["result" => $pinjaman]);
    }
}

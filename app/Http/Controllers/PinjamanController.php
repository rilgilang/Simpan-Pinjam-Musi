<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pinjaman;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinjamanController extends Controller
{
    public function pinjamanList(): View{

        $pinjaman = Pinjaman::join('anggota', 'anggota.id', '=', 'pinjaman.id_anggota')
        ->join('users', 'anggota.id_user', '=', 'users.id')
        ->select('users.id', 'users.name', 'pinjaman.id_anggota', 'pinjaman.bunga_pinjaman_per_bulan', 'pinjaman.jumlah_pinjaman', 'pinjaman.created_at','pinjaman.angsuran_per_bulan', 'pinjaman.status', 'pinjaman.total_pinjaman')
        ->get();

        
    return view('pinjaman/pinjaman-list', ["result" => $pinjaman]);
    }

    public function pengajuanPinjaman(Request $req): View{
         $req->validate(
            [
                'jumlah_pinjaman' => 'required|numeric',
                'angsuran' => 'required|numeric',
                'total_pengajuan' => 'required|numeric',
            ],
            [
                'jumlah_pinjaman.required' => 'jumlah pinjaman anggota wajib diisi.',
                'angsuran.required' => 'angsuran wajib diisi.',
                'total_pengajuan.required' => 'total pengajuan wajib diisi.',
            ]
        );

        
        $userId = Auth::id(); // Get the current user's ID

        $anggota = Anggota::where('id_user', $userId)->first();
        
        
         Pinjaman::create([
            'id_anggota' => $anggota['id'],
            'jumlah_pinjaman' => $req['jumlah_pinjaman'],
            'bunga_pinjaman_per_bulan' => 1,
            'angsuran_per_bulan' => $req['angsuran'],
            'status' => 'menunggu',
            'total_pinjaman' => $req['total_pengajuan'],
        ]);

        $pinjaman = Pinjaman::join('anggota', 'anggota.id', '=', 'pinjaman.id_anggota')
        ->join('users', 'anggota.id_user', '=', 'users.id')
        ->select('users.id', 'users.name', 'pinjaman.id_anggota', 'pinjaman.bunga_pinjaman_per_bulan', 'pinjaman.jumlah_pinjaman', 'pinjaman.created_at','pinjaman.angsuran_per_bulan', 'pinjaman.status', 'pinjaman.total_pinjaman')
        ->get();
    return view('pinjaman/pinjaman-list', ["result" => $pinjaman]);
    }
}

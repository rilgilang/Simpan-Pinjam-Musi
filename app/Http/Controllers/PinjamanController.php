<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Angsuran;
use App\Models\PengajuanPinjaman;
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

    public function pengajuanPinjamanList(): View{

        $pinjaman = PengajuanPinjaman::join('anggota', 'anggota.id', '=', 'pengajuan_pinjaman.id_anggota')
        ->join('users', 'anggota.id_user', '=', 'users.id')
        ->select('pengajuan_pinjaman.id', 'users.name', 'pengajuan_pinjaman.id_anggota', 'pengajuan_pinjaman.bunga_pinjaman_per_bulan', 'pengajuan_pinjaman.jumlah_pinjaman', 'pengajuan_pinjaman.created_at','pengajuan_pinjaman.angsuran_per_bulan', 'pengajuan_pinjaman.total_pinjaman', 'pengajuan_pinjaman.status_persetujuan_admin',  'pengajuan_pinjaman.status_persetujuan_ketua')
        ->get();

        
    return view('pinjaman/pengajuan-pinjaman-list', ["result" => $pinjaman]);
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
        
        
         PengajuanPinjaman::create([
            'id_anggota' => $anggota['id'],
            'jumlah_pinjaman' => $req['jumlah_pinjaman'],
            'bunga_pinjaman_per_bulan' => 1,
            'angsuran_per_bulan' => $req['angsuran'],
            'total_pinjaman' => $req['total_pengajuan'],
            'status_persetujuan_admin' => 'menunggu',
            'status_persetujuan_ketua' => 'menunggu',
        ]);

        $pinjaman = Pinjaman::all()->where('id_anggota', $anggota['id']);

    return view('pinjaman/pengajuan-pinjaman-list', ["result" => $pinjaman]);
    }

    public function approvePengajuanPinjaman($id): View{
    
        $user = Auth::user(); // Get the authenticated user

        $pengajuan = PengajuanPinjaman::where('id', $id)->select('*')->first();

        // dd($pengajuan);

        if ($user->hasRole('admin')) {
            PengajuanPinjaman::where('id', $id)->update(['status_persetujuan_admin' => 'disetujui']);        
            if ($pengajuan->status_persetujuan_ketua == 'disetujui') {
                $pinjaman = Pinjaman::create([
                    'id_anggota' => $pengajuan['id_anggota'],
                    'id_pengajuan' => $pengajuan['id'],
                    'jumlah_pinjaman' => $pengajuan['jumlah_pinjaman'],
                    'bunga_pinjaman_per_bulan' => $pengajuan['bunga_pinjaman_per_bulan'],
                    'angsuran_per_bulan' => $pengajuan['angsuran_per_bulan'],
                    'status' => 'belum lunas',
                    'total_pinjaman' => $pengajuan['total_pinjaman'],
                ]);

                $this->generateAngsuran(10, $pinjaman);
            }
        }

        if ($user->hasRole('ketua')) {
            PengajuanPinjaman::where('id', $id)->update(['status_persetujuan_ketua' => 'disetujui']);        
            if ($pengajuan->status_persetujuan_admin == 'disetujui') {
                $pinjaman = Pinjaman::create([
                    'id_anggota' => $pengajuan['id_anggota'],
                    'id_pengajuan' => $pengajuan['id'],
                    'jumlah_pinjaman' => $pengajuan['jumlah_pinjaman'],
                    'bunga_pinjaman_per_bulan' => $pengajuan['bunga_pinjaman_per_bulan'],
                    'angsuran_per_bulan' => $pengajuan['angsuran_per_bulan'],
                    'status' => 'belum lunas',
                    'total_pinjaman' => $pengajuan['total_pinjaman'],
                ]);

                $this->generateAngsuran(10, $pinjaman);
            }
        }



        $pinjaman = PengajuanPinjaman::join('anggota', 'anggota.id', '=', 'pengajuan_pinjaman.id_anggota')
        ->join('users', 'anggota.id_user', '=', 'users.id')
        ->select('pengajuan_pinjaman.id', 'users.name', 'pengajuan_pinjaman.id_anggota', 'pengajuan_pinjaman.bunga_pinjaman_per_bulan', 'pengajuan_pinjaman.jumlah_pinjaman', 'pengajuan_pinjaman.created_at','pengajuan_pinjaman.angsuran_per_bulan', 'pengajuan_pinjaman.total_pinjaman', 'pengajuan_pinjaman.status_persetujuan_admin',  'pengajuan_pinjaman.status_persetujuan_ketua')
        ->get();

        return view('pinjaman/pengajuan-pinjaman-list', ["result" => $pinjaman]);
    }
    
    private function generateAngsuran($tenor, $pinjaman){


        $angsuran_arr = [];

        for ($i=0; $i < $tenor; $i++) { 
            $angsuran = [
                'id_pinjaman' => $pinjaman->id,
                'jumlah' => $pinjaman->jumlah,
                'pembayaran_ke' => $i + 1,
                'status' => 'belum dibayar'
            ];

            array_push($angsuran_arr, $angsuran);
        }

        Angsuran::create($angsuran_arr);
        
    return view('pinjaman/pengajuan-pinjaman-list', ["result" => $pinjaman]);
    }
}

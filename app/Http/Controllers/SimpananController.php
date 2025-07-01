<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\Anggota;
use App\Models\User;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SimpananController extends Controller
{
    public function simpananList(): View{
        $simpanan = Simpanan::join('anggota', 'anggota.id', '=', 'simpanan.id_anggota')
        ->join('users', 'users.id', '=', 'anggota.id_user')
        ->select('users.name', 'simpanan.simpanan_wajib', 'simpanan.simpanan_pokok', 'simpanan.simpanan_sukarela', 'simpanan.jumlah')
        ->get();

        $users = User::all();

        $anggotaList = [];

        foreach ($users as $user) {
            if ($user->hasRole('anggota')){
                array_push($anggotaList, $user);
            }
        }
            
        return view('simpanan/simpanan-list', ["simpanan_list" => $simpanan, "anggota_list" => $anggotaList]);
    }

     public function exportSimpananToPdf(){
       $simpanan = DB::table('simpanan')
        ->join('users', 'users.id', '=', 'simpanan.id_anggota')
        ->select(
            'users.name',
            DB::raw('SUM(simpanan.simpanan_wajib) as total_wajib'),
            DB::raw('SUM(simpanan.simpanan_pokok) as total_pokok'),
            DB::raw('SUM(simpanan.simpanan_sukarela) as total_sukarela'),
            DB::raw('SUM(simpanan.jumlah) as total_jumlah')
        )
        ->groupBy('users.id', 'users.name')
        ->get();

        $users = User::all();

        $anggotaList = [];

        foreach ($users as $user) {
            if ($user->hasRole('anggota')){
                array_push($anggotaList, $user);
            }
        }
        
        $pdf = PDF::loadView('exports.simpanan-list-export', [
            'simpanan' => $simpanan
        ])->setPaper('a4', 'portrait');

        return $pdf->download('daftar-simpanan-' . Carbon::now()->format('Ymd_His') . '.pdf');
    }

    public function simpananSave(Request $req)
    {

        $req->validate(
            [
                'id_user' => 'required|numeric',
                'simpanan_wajib' => 'required|numeric',
                'simpanan_pokok' => 'required|numeric',
                'simpanan_sukarela' => 'required|numeric',
            ],
            [
                'id_user.required' => 'Id User wajib diisi.',
                'simpanan_wajib.required' => 'Simpanan wajib, wajib diisi.',
                'simpanan_pokok.required' => 'Simpanan pokok wajib diisi.',
                'simpanan_sukarela.required' => 'Simpanan sukarela wajib diisi.',
            ]
        );

        $anggota = Anggota::where('id_user', '=', $req['id_user'])->first();

        $simpanan = Simpanan::create([
            'id_anggota' => $anggota->id,
            'simpanan_wajib' => $req['simpanan_wajib'],
            'simpanan_pokok' => $req['simpanan_pokok'],
            'simpanan_sukarela' => $req['simpanan_sukarela'],
            'jumlah' => $req['simpanan_wajib'] + $req['simpanan_pokok'] + $req['simpanan_sukarela'],
        ]);

    
        return redirect('simpanan');
    }

}

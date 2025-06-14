<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SimpananController extends Controller
{
    public function simpananList(): View{
        $simpanan = DB::table('simpanan')
        ->join('users', 'users.id', '=', 'simpanan.id_anggota')
        ->select('users.name', 'simpanan.simpanan_wajib', 'simpanan.simpanan_pokok', 'simpanan.simpanan_sukarela', 'simpanan.jumlah')
        ->get();

        $users = User::all();

        $anggotaList = [];

        foreach ($users as $user) {
            
            if ($user->hasRole('anggota')){
                array_push($anggotaList, $user);
            }
        }

        return view('simpanan/simpanan-list', ["simpanan" => $simpanan, "anggota_list" => $anggotaList]);
    }

    public function simpananSave(Request $req)
    {

        $req->validate(
            [
                'id_anggota' => 'required|numeric',
                'simpanan_wajib' => 'required|numeric',
                'simpanan_pokok' => 'required|numeric',
                'simpanan_sukarela' => 'required|numeric',
            ],
            [
                'id_anggota.required' => 'Nama anggota wajib diisi.',
                'simpanan_wajib.required' => 'Simpanan wajib, wajib diisi.',
                'simpanan_pokok.required' => 'Simpanan pokok wajib diisi.',
                'simpanan_sukarela.required' => 'Simpanan sukarela wajib diisi.',
            ]
        );


        $simpanan = Simpanan::create([
            'id_anggota' => $req['id_anggota'],
            'simpanan_wajib' => $req['simpanan_wajib'],
            'simpanan_pokok' => $req['simpanan_pokok'],
            'simpanan_sukarela' => $req['simpanan_sukarela'],
            'jumlah' => $req['simpanan_wajib'] + $req['simpanan_pokok'] + $req['simpanan_sukarela'],
        ]);

    
        return redirect('simpanan');
    }

}

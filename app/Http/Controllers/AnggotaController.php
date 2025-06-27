<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnggotaController extends Controller
{
     public function anggotaSave(Request $req)
    {

        $req->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'password' => 'required|string|max:255',
                'nomor_hp' => 'required|unique:anggota|string|max:15',
                'alamat' => 'required|string|max:300',
            ],
            [
                'name.required' => 'Nama anggota wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'password.required' => 'Password wajib diisi.',
                'nomor_hp.required' => 'Nomor Handphone wajib diisi.',
                'alamat.required' => 'Alamat wajib diisi.',
            ]
        );

        $user = User::create([
            'name' => $req['name'],
            'email' => $req['email'],
            'password' => $req['password'],
        ]);

        $user->assignRole('anggota');
    

        $anggota = Anggota::create([
            'id_user' => $user['id'],
            'alamat' => $req['alamat'],
            'nik' => $req['nik'],
            'nomor_hp' => $req['nomor_hp'],
            'status' => 'aktif',
        ]);

        // Mail::to($req->email)->send(new SendEmail(
        //     $req->nama_penghuni,
        //     'Survei Non Pelanggan PDAM TIRTA MUSI',
        //     now()->format('d-m-Y'),
        //     '',
        //     'Dinas Pelayanan Umum'
        // ));

        
        // Alert::toast('Survei Anda telah kami terima. Terima kasih atas kontribusinya dalam pengembangan layanan kami.');
       
        return redirect("/anggota");
    }

    public function anggotaList(): View{

        $users = User::join('anggota', 'anggota.id_user', '=', 'users.id')
        ->select('users.id', 'users.name', 'users.email', 'anggota.nik', 'anggota.alamat', 'anggota.nomor_hp', 'anggota.created_at')
        ->get();

        $result = [];

        foreach ($users as $user) {
        
            if ($user->hasRole('anggota')){
                $user->created_at = Carbon::parse($user['created_at'])->format('d M Y');
                array_push($result, $user);
            }
        }

        return view('anggota/anggota-list', ["result" => $result]);
    }

    public function anggotaDetail($id): View{

    $user = User::join('anggota', 'anggota.id_user', '=', 'users.id')
        ->select('users.id', 'users.name', 'users.email', 'anggota.nik', 'anggota.alamat', 'anggota.nomor_hp', 'anggota.created_at', 'anggota.riwayat_pinjaman')
        ->where('users.id', $id)
        ->first();

        return view('anggota/anggota-detail', compact('user'));
    }
}

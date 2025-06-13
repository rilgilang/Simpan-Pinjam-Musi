<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Bool_;

class AnggotaController extends Controller
{
     public function anggotaSave(Request $req): View
    {
        $req->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'password' => 'required|string|max:255',
                'phone_number' => 'required|string|max:15',
                'address' => 'required|string|max:300',
            ],
            [
                'name.required' => 'Nama pemilik wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'password.required' => 'Password wajib diisi.',
                'phone_number.required' => 'Nomor Handphone wajib diisi.',
                'address.required' => 'Alamat wajib diisi.',
            ]
        );


        $user = User::create([
            'name' => $req['name'],
            'email' => $req['email'],
            'password' => $req['password'],
            'phone_number' => $req['phone_number'],
            'address' => $req['address'],
        ]);

        $user->assignRole('anggota');
        

        // Mail::to($req->email)->send(new SendEmail(
        //     $req->nama_penghuni,
        //     'Survei Non Pelanggan PDAM TIRTA MUSI',
        //     now()->format('d-m-Y'),
        //     '',
        //     'Dinas Pelayanan Umum'
        // ));

        
        // Alert::toast('Survei Anda telah kami terima. Terima kasih atas kontribusinya dalam pengembangan layanan kami.');
        return view('anggota-list');
    }

    public function anggotaList(): View{

        $users = User::all();

        $result = [];

        foreach ($users as $user) {
            
            if ($user->hasRole('anggota')){
                array_push($result, $user);
            }
        }

        return view('anggota/anggota-list', ["result" => $result]);
    }
}

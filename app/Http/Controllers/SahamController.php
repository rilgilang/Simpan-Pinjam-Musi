<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\Anggota;
use App\Models\IndexSaham;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SahamController extends Controller
{
    public function indexSahamList(): View{
        $saham = IndexSaham::all();

        return view('index-saham', ["result" => $saham]);
    }

    public function indexSahamSave(Request $req)
    {

        $req->validate(
            [
                'index_saham' => 'required|numeric',
                'tahun' => 'required|numeric',
            ],
            [
                'index_saham.required' => 'Id User wajib diisi.',
                'tahun.required' => 'Simpanan wajib, wajib diisi.',
            ]
        );

        $indexSaham = IndexSaham::create([
            'index_saham' => $req['index_saham'],
            'tahun' => $req['tahun'],
        ]);
    
        return redirect('shu');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminSave(Request $req)
    {

        $req->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|max:255',
                'password' => 'required|string|max:255',
            ],
            [
                'name.required' => 'Nama anggota wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'password.required' => 'Password wajib diisi.',
            ]
        );

        $user = User::create([
            'name' => $req['name'],
            'email' => $req['email'],
            'password' => $req['password'],
        ]);

        $user->assignRole('admin');
       
        return redirect("/admin");
    }

     public function adminList(): View{

        $users = User::all();

        $result = [];

        foreach ($users as $user) {
        
            if ($user->hasRole('admin')){
                $user->created_at = Carbon::parse($user['created_at'])->format('d M Y');
                array_push($result, $user);
            }
        }

        return view('admin/admin-list', ["admins" => $result]);
    }

    public function adminDelete($id) {
        $admin = User::find($id);
        $admin->delete();
        return redirect("/admin");
    }
}

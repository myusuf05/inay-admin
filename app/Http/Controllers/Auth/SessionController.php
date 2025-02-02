<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{

    public function index()
    {
        return view('pages.auth.login');
    }

    public function login(Request $req)
    {
        $this->validate($req, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $in_user = [
            'email' => $req->email,
            'password' => $req->password,
            'is_aktif' => '1'
        ];

        $user = User::where('email', $req->email)->firstOrFail();

        if ($user) {
            if (Auth::attempt($in_user)) {
                $user->remember_token = $req->_token;
                $user->save();

                return response('Sukses login', 200);
            }

            if ($user->is_aktif == '0') {
                return response('User tidak aktif. Silahkan hubungi admin untuk mengaktifkan', 401);
            }
        }

        return response('User tidak terdaftar', 401);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

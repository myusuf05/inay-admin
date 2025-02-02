<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Pendataan\Santri as PendataanSantri;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{


    public function login(Request $req)
    {
        $this->validate($req, [
            'id_santri' => 'required|id_santri',
            'password' => 'required|min:8'
        ], [
            'id_santri.required' => 'id_santri wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $santri = PendataanSantri::where('id_santri', $req->id_santri)->firstOrFail();

        if ($santri && $santri->password == $req->password) {
            $token = $santri->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Sukses login',
                'santri' => $santri,
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'NIS atau password salah'
            ], 400);
        }

        // $in_user = [
        //     'id_santri' => $req->id_santri,
        //     'password' => $req->password,
        //     'is_aktif' => '1'
        // ];

        // $user = User::where('id_santri', $req->id_santri)->firstOrFail();

        // if ($user) {
        //     if (Auth::attempt($in_user)) {
        //         $user->remember_token = $req->_token;
        //         $user->save();

        //         return response('Sukses login', 200);
        //     }

        //     if ($user->is_aktif == '0') {
        //         return response('User tidak aktif. Silahkan hubungi admin untuk mengaktifkan', 401);
        //     }
        // }

        return response('User tidak terdaftar', 401);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
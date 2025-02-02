<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pendataan\Kelas;
use Illuminate\Http\Request;

class ApiKelasController extends Controller
{
    public function get_kelas(Request $request)
    {
        if (isset($request->id_kelas)) {
            $kelas = Kelas::findOrFail($request->id_kelas);
        } else {
            $kelas = Kelas::all();
        }
        return response()->json($kelas);
    }
}

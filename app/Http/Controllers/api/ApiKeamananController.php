<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Akademik\Presensi;
use Illuminate\Http\Request;

class ApiKeamananController extends Controller
{
    public function get_keamanan(Request $request)
    {
        if (isset($request->id_presensi)) {
            $presensi = Presensi::findOrFail($request->id_presensi);
        } else {
            $presensi = Presensi::all();
        }
        return response()->json($presensi);
    }
}

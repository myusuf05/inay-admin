<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Akademik\Pengajar;
use Illuminate\Http\Request;

class ApiPengajarController extends Controller
{
    public function get_pengajar(Request $request)
    {
        if (isset($request->id_pengajar)) {
            $pengajar = Pengajar::findOrFail($request->id_pengajar);
        } else {
            $pengajar = Pengajar::all();
        }
        return response()->json($pengajar);
    }
}

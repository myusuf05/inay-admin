<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Akademik\Nilai;
use Illuminate\Http\Request;

class ApiNilaiController extends Controller
{
    public function get_nilai(Request $request)
    {
        if (isset($request->id_nilai)) {
            $nilai = Nilai::findOrFail($request->id_nilai);
        } else {
            $nilai = Nilai::all();
        }
        return response()->json($nilai);
    }
}

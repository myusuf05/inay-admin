<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Akademik\Mapel;
use Illuminate\Http\Request;

class ApiJadwalController extends Controller
{
    public function get_jadwal(Request $request)
    {
        if (isset($request->id_mapel)) {
            $mapel = Mapel::findOrFail($request->id_mapel);
        } else {
            $mapel = Mapel::all();
        }
        return response()->json($mapel);
    }
}

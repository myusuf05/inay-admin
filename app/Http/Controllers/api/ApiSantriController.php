<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pendataan\Santri;
use Illuminate\Http\Request;

class ApiSantriController extends Controller
{
    public function get(Request $request)
    {
        $santri = Santri::findOrFail('25011000');

        return response()->json($santri);
    }
}
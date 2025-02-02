<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pendataan\Santri as PendataanSantri;
use Illuminate\Http\Request;

class ApiSantriController extends Controller
{
    public function get(Request $request)
    {
        $db_santri = PendataanSantri::select([
            'id_santri',
            'santri.nama as santri_nama',
            'santri.jenis_kelamin as santri_gender',
            'ayah.id_pendidikan as ayah_pendidikan',
            'ibu.id_pendidikan as ibu_pendidikan',
            'ayah.id_pekerjaan as ayah_pekerjaan',
            'ibu.id_pekerjaan as ibu_pekerjaan',
            'santri.password as password',
            'santri.id_santri as status_santri',
            'ibu.id_gaji as ibu_gaji',
            'ayah.id_gaji as ayah_gaji',
            'kelas.kelas as santri_kelas',
            'santri.id_kamar as santri_kamar'
        ])
            ->leftJoin('orang_tua as ayah', 'santri.id_ayah', '=', 'ayah.id_ortu')
            ->leftJoin('orang_tua as ibu', 'santri.id_ibu', '=', 'ibu.id_ortu')
            ->leftJoin('kelas', 'santri.id_kelas', '=', 'kelas.id_kelas')
            ->where('santri.id_santri', '=', '25011000');

        if ($db_santri == null) {
            return response()->status(404);
        }

        return response(json_encode($db_santri->get()->first()), 200);
    }
}
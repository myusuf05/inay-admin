<?php

namespace App\Http\Controllers\Pendataan;

use App\Http\Controllers\Controller;
use App\Models\Pendataan\Alumni as PendataanAlumni;
use App\Models\Pendataan\OrangTua as PendataanOrtu;
use App\Models\Pendataan\Santri as PendataanSantri;
use App\Models\Pendataan\Setting\Gaji;
use App\Models\Pendataan\Setting\Pekerjaan;
use App\Models\Pendataan\Setting\Pendidikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumniController extends Controller
{
    public function index()
    {
        return view('pages.admin.pendataan.alumni.index', ['type_menu' => 'data_alumni']);
    }

    public function show($id)
    {
        $auth = Auth::user()->akses;
        $db_alumni = PendataanAlumni::find($id);

        if ($db_alumni == null) {
            return view('pages.error.404', ['type_menu' => 'data_alumni']);
        }

        $db_ayah = PendataanOrtu::find($db_alumni->id_ayah);
        $db_ibu = PendataanOrtu::find($db_alumni->id_ibu);
        $select_ibu = [
            'gaji' => Gaji::find($db_ibu->id_gaji),
            'job' => Pekerjaan::find($db_ibu->id_pekerjaan),
            'study' => Pendidikan::find($db_ibu->id_pendidikan),
        ];

        $select_ayah = [
            'gaji' => Gaji::find($db_ayah->id_gaji),
            'job' => Pekerjaan::find($db_ayah->id_pekerjaan),
            'study' => Pendidikan::find($db_ayah->id_pendidikan),
        ];

        $data = [
            'santri' => $db_alumni,
            'ibu' => $db_ibu,
            'select' => [
                'ibu' => $select_ibu,
                'ayah' => $select_ayah
            ],
            'ayah' => $db_ayah,
        ];
        if ($auth === 'yayasan') {
            return view('pages.yayasan.alumni', ['type_menu' => 'data_alumni', 'data' => $data]);
        } else {
            return view('pages.admin.pendataan.alumni.show', ['type_menu' => 'data_alumni', 'data' => $data]);
        }
    }

    public function get_data(Request $req)
    {
        $order_column = [
            0 => 'id_alumni',
            1 => 'nama',
            2 => 'tgl_masuk',
            3 => 'tgl_keluar'
        ];

        $recordsTotal = PendataanAlumni::count();

        $db_alumni = PendataanAlumni::select([
            'id_alumni',
            'nama',
            'tgl_masuk',
            'tgl_keluar'
        ]);

        // Search Query
        if ($req->input('search.value') != '') {
            $db_alumni = $db_alumni->where('nama', 'like', '%' . $req->input('search.value') . '%');
        }

        // Order Query
        $db_alumni = $db_alumni->orderBy(
            $order_column[$req->input('order.0.column')],
            $req->input('order.0.dir')
        );

        $recordsFiltered = $db_alumni->count();

        // Limit Query
        if ($req->input('length') != 1) {
            $db_alumni = $db_alumni->skip($req->input('start'))->take($req->input('length'));
        }

        $db_alumni = $db_alumni->get()->toArray();
        $data = [];
        foreach ($db_alumni as $i => $r) {
            $sub_array = [];
            $sub_array[] = $r['id_alumni'];
            $sub_array[] = $r['nama'];
            $sub_array[] = $r['tgl_masuk'];
            $sub_array[] = $r['tgl_keluar'];
            if (Auth::user()->akses === 'yayasan') {
                $sub_array[] = '
          <div class="text-center">
            <a class="btn btn-info btn-circle btn-sm btn-table btn-edit" href="/pendataan/alumni/' . $r['id_alumni'] . '">
              <i class="fas fa-eye"></i></button>
            </a>
          </div>
        ';
            } else if (Auth::user()->akses === 'admin') {
                $sub_array[] = '
        <div class="text-center">
          <a class="btn btn-success btn-circle btn-sm btn-table btn-edit" href="/pendataan/alumni/' . $r['id_alumni'] . '">
            <i class="fas fa-pencil"></i></button>
          </a>
          <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
            data-id="' . $r['id_alumni'] . '">
            <i class="fas fa-trash"></i></button>
          </button>
        </div>
      ';
            } else {
                $sub_array[] = '';
            }

            $data[] = $sub_array;
        }

        $output = [
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ];

        return json_encode($output);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'santri' => 'required',
            'tgl_keluar' => 'required'
        ]);

        $santri = PendataanSantri::find($req->santri);

        if (empty($santri)) {
            return response('ID Santri tidak ditemukan', 404);
        }

        $alumni = new PendataanAlumni;

        if (!empty($alumni->find($req->santri))) {
            return response('ID Santri sudah ada di data alumni', 400);
        }

        $alumni->id_alumni = $santri->id_santri;
        $alumni->id_ayah = $santri->id_ayah;
        $alumni->id_ibu = $santri->id_ibu;
        $alumni->nama = strtoupper($santri->nama);
        $alumni->photo = $santri->photo;
        $alumni->alamat = $santri->alamat;
        $alumni->tgl_lahir = $santri->tgl_lahir;
        $alumni->jenis_kelamin = $santri->jenis_kelamin;
        $alumni->no_hp = $santri->no_hp;
        $alumni->email = $santri->email;
        $alumni->nik = $santri->nik;
        $alumni->tgl_masuk = $santri->tgl_masuk;
        $alumni->tgl_keluar = $req->tgl_keluar;

        if ($alumni->save()) {
            $santri->delete();
            return response('Sukses', 200);
        }

        return response('Gagal', 500);
    }

    public function get_by_id($id)
    {
        $db_alumni = PendataanAlumni::select([
            'id_alumni',
            'alumni.jenis_kelamin as alumni_gender',
            'ayah.id_pendidikan as ayah_pendidikan',
            'ibu.id_pendidikan as ibu_pendidikan',
            'ayah.id_pekerjaan as ayah_pekerjaan',
            'ibu.id_pekerjaan as ibu_pekerjaan',
            'ayah.id_gaji as ayah_gaji',
            'ibu.id_gaji as ibu_gaji'
        ])
            ->leftJoin('orang_tua as ayah', 'alumni.id_ayah', '=', 'ayah.id_ortu')
            ->leftJoin('orang_tua as ibu', 'alumni.id_ibu', '=', 'ibu.id_ortu')
            ->where('alumni.id_alumni', '=', $id);

        if ($db_alumni == null) {
            return response()->status(404);
        }

        return response(json_encode($db_alumni->get()->first()), 200);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req, [
            'alumni_nama' => 'required|min:5',
            'alumni_gender' => 'required|min:1|max:1',
            'alumni_birth' => 'required',
            'alumni_nik' => 'required|min:5',
            'alumni_hp' => 'required|min:5',
            'alumni_email' => 'required|min:5',
            'alumni_in' => 'required',
            'alumni_out' => 'required',
            'alumni_alamat' => 'required|min:5',
            'ayah_nama' => 'required|min:5',
            'ayah_nik' => 'required|min:5',
            'ayah_hp' => 'required|min:5',
            'ayah_gaji' => 'required|min:1',
            'ayah_job' => 'required|min:1',
            'ayah_study' => 'required|min:1',
            'ayah_alamat' => 'required|min:1',
            'ibu_nama' => 'required|min:5',
            'ibu_nik' => 'required|min:5',
            'ibu_hp' => 'required|min:5',
            'ibu_alamat' => 'required|min:5',
            'ibu_gaji' => 'required|min:1',
            'ibu_job' => 'required|min:1',
            'ibu_study' => 'required|min:1',
        ]);

        $db_alumni = PendataanAlumni::find($id);

        $db_alumni->nama = strtoupper($req->alumni_nama);
        $db_alumni->tgl_lahir = $req->alumni_birth;
        $db_alumni->jenis_kelamin = $req->alumni_gender;
        $db_alumni->no_hp = $req->alumni_hp;
        $db_alumni->alamat = $req->alumni_alamat;
        $db_alumni->email = $req->alumni_email;
        $db_alumni->nik = $req->alumni_nik;
        $db_alumni->tgl_masuk = $req->alumni_in;
        $db_alumni->tgl_keluar = $req->alumni_out;
        $db_alumni->save();

        $db_ayah = new PendataanOrtu;
        if (isset($db_alumni->id_ayah)) {
            $db_ayah = $db_ayah->find($db_alumni->id_ayah);
        }

        $db_ayah->id_pendidikan = $req->ayah_study;
        $db_ayah->id_pekerjaan = $req->ayah_job;
        $db_ayah->id_gaji = $req->ayah_gaji;
        $db_ayah->nama = strtoupper($req->ayah_nama);
        $db_ayah->alamat = $req->ayah_alamat;
        $db_ayah->no_hp = $req->ibu_hp;
        $db_ayah->nik = $req->ibu_nik;

        if ($db_ayah->save()) {
            $db_alumni->id_ayah = $db_ayah->getKey();
            $db_alumni->save();
        }

        $db_ibu = new PendataanOrtu;

        if (isset($db_alumni->id_ibu)) {
            $db_ibu = $db_ibu->find($db_alumni->id_ibu);
        }

        $db_ibu->id_pendidikan = $req->ibu_study;
        $db_ibu->id_pekerjaan = $req->ibu_job;
        $db_ibu->id_gaji = $req->ibu_gaji;
        $db_ibu->nama = strtoupper($req->ibu_nama);
        $db_ibu->alamat = $req->ibu_alamat;
        $db_ibu->no_hp = $req->ayah_hp;
        $db_ibu->nik = $req->ibu_nik;

        if ($db_ibu->save()) {
            $db_alumni->id_ibu = $db_ibu->getKey();
            $db_alumni->save();
        }

        return response('', 200);
    }

    public function destroy($id)
    {
        $kelas = PendataanAlumni::find($id);

        if ($kelas->delete()) {
            return response('Sukses Hapus', 200);
        }

        return response('', 400);
    }
}
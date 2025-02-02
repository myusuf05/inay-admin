<?php

namespace App\Http\Controllers\Pendataan;

use App\Http\Controllers\Controller;
use App\Models\Pendataan\Alumni as PendataanAlumni;
use App\Models\Pendataan\Kamar;
use App\Models\Pendataan\Kelas;
use App\Models\Pendataan\OrangTua as PendataanOrtu;
use App\Models\Pendataan\Santri as PendataanSantri;
use App\Models\Pendataan\Setting\Gaji;
use App\Models\Pendataan\Setting\Pekerjaan;
use App\Models\Pendataan\Setting\Pendidikan;
use App\Models\Pendataan\Setting\StatusSantri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\type;

class SantriController extends Controller
{
    /* View */
    public function index()
    {
        return view('pages.admin.pendataan.santri.index', ['type_menu' => 'data_santri']);
    }



    public function create()
    {
        return view('pages.admin.pendataan.santri.add', ['type_menu' => 'data_santri']);
    }

    public function show($id)
    {
        $auth = Auth::user()->akses;
        $db_santri = PendataanSantri::find($id);

        if ($db_santri == null) {
            return view('pages.error.404', ['type_menu' => 'data_santri']);
        }

        $db_ayah = PendataanOrtu::find($db_santri->id_ayah);
        $db_ibu = PendataanOrtu::find($db_santri->id_ibu);
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
            'santri' => $db_santri,
            'ibu' => $db_ibu,
            'select' => [
                'ibu' => $select_ibu,
                'ayah' => $select_ayah
            ],
            'ayah' => $db_ayah,
            'status_santri' => StatusSantri::find($db_santri->id_santi),
            'kelas' => Kelas::find($db_santri->id_kelas),
            'kamar' => Kamar::find($db_santri->id_kamar)
        ];

        if ($auth === 'yayasan') {
            return view('pages.yayasan.santri', ['type_menu' => 'data_santri', 'data' => $data]);
        } else {
            return view('pages.admin.pendataan.santri.show', ['type_menu' => 'data_santri', 'data' => $data]);
        }
    }

    /* Controller */
    public function get_data(Request $req)
    {
        $order_column = [
            0 => 'santri.id_santri',
            1 => 'santri.nama',
            2 => 'kamar.kamar',
            3 => 'kelas.kelas'
        ];

        $recordsTotal = PendataanSantri::count();

        $rooms = PendataanSantri::select([
            'santri.id_santri',
            'santri.nama',
            'kelas.kelas',
            'kamar.kamar'
        ])->leftJoin('kelas', 'santri.id_kelas', '=', 'kelas.id_kelas')
            ->leftJoin('kamar', 'santri.id_kamar', '=', 'kamar.id_kamar');

        // Search Query
        if ($req->input('search.value') != '') {
            $rooms = $rooms->where('santri.nama', 'like', '%' . $req->input('search.value') . '%');
        }

        // Order Query
        $rooms = $rooms->orderBy(
            $order_column[$req->input('order.0.column')],
            $req->input('order.0.dir')
        );

        $recordsFiltered = $rooms->count();

        // Limit Query
        if ($req->input('length') != 1) {
            $rooms = $rooms->skip($req->input('start'))->take($req->input('length'));
        }

        // dd($rooms);
        $rooms = $rooms->get()->toArray();
        $data = [];
        foreach ($rooms as $i => $r) {
            $sub_array = [];
            $sub_array[] = $r['id_santri'];
            $sub_array[] = $r['nama'];
            $sub_array[] = $r['kamar'];
            $sub_array[] = $r['kelas'];
            if (Auth::user()->akses === 'yayasan') {
                $sub_array[] = '
          <div class="text-center">
            <a class="btn btn-info btn-circle btn-sm btn-table btn-edit" href="/pendataan/santri/' . $r['id_santri'] . '">
              <i class="fas fa-eye"></i></button>
            </a>
          </div>
        ';
            } else if (Auth::user()->akses === 'admin') {
                $sub_array[] = '
          <div class="text-center">
            <a class="btn btn-success btn-circle btn-sm btn-table btn-edit" href="/pendataan/santri/' . $r['id_santri'] . '">
              <i class="fas fa-pencil"></i>edit</button>
            </a>
            <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
              data-id="' . $r['id_santri'] . '">
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


    protected function generate_id($thn_masuk, $gender)
    {
        $thn_id = Carbon::createFromFormat('Y-m-d', $thn_masuk)->format('ym');
        $gender_id = $gender === 'L' ? '1' : '2';

        $max_id_santri = PendataanSantri::where('id_santri', 'like', '%' . $thn_id . $gender_id . '%')->max('id_santri');
        $max_id_alumni = PendataanAlumni::where('id_alumni', 'like', '%' . $thn_id . $gender_id . '%')->max('id_alumni');

        if ($max_id_alumni > $max_id_santri) {
            $max_id_santri = $max_id_alumni;
        }

        $right_id = substr($max_id_santri, 5);
        $left_id = $thn_id . $gender_id;

        if ($max_id_santri === null) {
            $max_id_santri = sprintf('%03d', 0);
        } else {
            $max_id_santri = sprintf('%03d', (int)$right_id + 1);
        }

        return $thn_id . $gender_id . $max_id_santri;
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'santri_nama' => 'required|min:5',
            'santri_gender' => 'required|min:1|max:1',
            'santri_birth' => 'required',
            'santri_nik' => 'required|min:5',
            'santri_hp' => 'required|min:5',
            'santri_email' => 'required|min:5',
            // 'santri_password' => 'required|min:5',
            'santri_in' => 'required',
            'santri_alamat' => 'required|min:5',
            'santri_status' => 'required',
            // 'santri_kelas' => 'required',
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

        $santri = new PendataanSantri;

        // Save Data Ayah
        $ortu = new PendataanOrtu;

        $search_ayah = $ortu->where('nik', '=', $req->ayah_nik)->get(['id_ortu']);

        // Save Data Ayahh);
        if ($search_ayah->count() < 1) {
            $ortu->nama = strtoupper($req->ayah_nama);
            $ortu->jenis_kelamin = 'L';
            $ortu->alamat = $req->ayah_alamat;
            $ortu->no_hp = $req->ayah_hp;
            $ortu->nik = $req->ayah_nik;
            $ortu->id_pendidikan = $req->ayah_study;
            $ortu->id_pekerjaan = $req->ayah_job;
            $ortu->id_gaji = $req->ayah_gaji;
            $ortu->save();
            $id_ayah = $ortu->getKey();
        } else {
            $id_ayah = $search_ayah->first()->id_ortu;
        }

        // Save Data Ibu
        $ortu = new PendataanOrtu;
        $search_ibu = $ortu->where('nik', '=', $req->ibu_nik)->get(['id_ortu']);
        if ($search_ibu->count() < 1) {
            $ortu->nama = strtoupper($req->ibu_nama);
            $ortu->jenis_kelamin = 'P';
            $ortu->alamat = $req->ibu_alamat;
            $ortu->no_hp = $req->ibu_hp;
            $ortu->nik = $req->ibu_nik;
            $ortu->id_pendidikan = $req->ibu_study;
            $ortu->id_pekerjaan = $req->ibu_job;
            $ortu->id_gaji = $req->ibu_gaji;
            $ortu->save();
            $id_ibu = $ortu->getKey();
        } else {
            $id_ibu = $search_ayah->first()->id_ortu;
        }

        // Save Data Santri
        $search_santri = $santri->where('nik', '=', $req->santri_nik);

        if ($search_santri->count() > 0) {
            return response('Data dengan nik tersebut sudah ada', 400);
        }

        // Generate id_santri
        $santri->id_santri = $this->generate_id($req->santri_in, $req->santri_gender);
        $santri->id_ayah = $id_ayah;
        $santri->id_ibu = $id_ibu;
        $santri->nama = strtoupper($req->santri_nama);
        $santri->tgl_lahir = $req->santri_birth;
        $santri->jenis_kelamin = $req->santri_gender;
        $santri->no_hp = $req->santri_hp;
        $santri->alamat = $req->santri_alamat;
        $santri->email = $req->santri_email;
        $santri->nik = $req->santri_nik;
        $santri->photo = $req->santri_foto;
        $santri->tgl_masuk = $req->santri_in;
        $santri->save();

        return response('Sukses tambah data', 200);
    }

    public function get_email_santri()
    {
        try {
            $email = PendataanSantri::select('id_santri', 'nama', 'email')
                ->whereNotNull('email')
                ->get();

            return response()->json([
                'status' => 200,
                'message' => 'Data email santri ditemukan',
                'data' => $email
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function test()
    {
        return response()->json([
            'message'   => 'success',
            'data'      => 'test',
        ], 200);
    }


    public function get_by_id($id)
    {
        $db_santri = PendataanSantri::select([
            'id_santri',
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
            ->where('santri.id_santri', '=', $id);

        if ($db_santri == null) {
            return response()->status(404);
        }

        return response(json_encode($db_santri->get()->first()), 200);
    }

    public function get_list(Request $req)
    {
        $santri = new PendataanSantri;

        if ($req->term['_type'] != 'query') {
            return response('Type not allowed', 400);
        }

        if (isset($req->term['term'])) {
            $santri = $santri->where('nama', 'like', '%' . $req->term['term'] . '%');
        }

        $santri = $santri->skip(0)->take(5);

        return json_encode($santri->get(['id_santri', 'nama']));
    }

    public function update(Request $req, $id)
    {
        $this->validate($req, [
            'santri_nama' => 'required|min:5',
            'santri_gender' => 'required|min:1|max:1',
            'santri_birth' => 'required',
            'santri_nik' => 'required|min:5',
            'santri_hp' => 'required|min:5',
            'santri_email' => 'required|min:5',
            'santri_password' => 'required|min:5',
            'santri_in' => 'required',
            'santri_alamat' => 'required|min:5',
            'santri_status' => 'required',
            'santri_kelas' => 'required',
            'santri_kamar' => 'required',
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

        $db_santri = PendataanSantri::find($id);

        $db_santri->nama = strtoupper($req->santri_nama);
        $db_santri->tgl_lahir = $req->santri_birth;
        $db_santri->jenis_kelamin = $req->santri_gender;
        $db_santri->no_hp = $req->santri_hp;
        $db_santri->alamat = $req->santri_alamat;
        $db_santri->email = $req->santri_email;
        $db_santri->password = $req->santri_password;
        $db_santri->nik = $req->santri_nik;
        $db_santri->tgl_masuk = $req->santri_in;
        // $db_santri->id_santri = $req->santri_status;
        $db_santri->id_kelas = $req->santri_kelas;
        $db_santri->id_kamar = $req->santri_kamar;
        $db_santri->save();

        $db_ayah = new PendataanOrtu;
        if (isset($db_santri->id_ayah)) {
            $db_ayah = $db_ayah->find($db_santri->id_ayah);
        }

        $db_ayah->id_pendidikan = $req->ayah_study;
        $db_ayah->id_pekerjaan = $req->ayah_job;
        $db_ayah->id_gaji = $req->ayah_gaji;
        $db_ayah->nama = strtoupper($req->ayah_nama);
        $db_ayah->alamat = $req->ayah_alamat;
        $db_ayah->no_hp = $req->ibu_hp;
        $db_ayah->nik = $req->ibu_nik;

        if ($db_ayah->save()) {
            $db_santri->id_ayah = $db_ayah->getKey();
            $db_santri->save();
        }

        $db_ibu = new PendataanOrtu;

        if (isset($db_santri->id_ibu)) {
            $db_ibu = $db_ibu->find($db_santri->id_ibu);
        }

        $db_ibu->id_pendidikan = $req->ibu_study;
        $db_ibu->id_pekerjaan = $req->ibu_job;
        $db_ibu->id_gaji = $req->ibu_gaji;
        $db_ibu->nama = strtoupper($req->ibu_nama);
        $db_ibu->alamat = $req->ibu_alamat;
        $db_ibu->no_hp = $req->ayah_hp;
        $db_ibu->nik = $req->ibu_nik;

        if ($db_ibu->save()) {
            $db_santri->id_ibu = $db_ibu->getKey();
            $db_santri->save();
        }

        return response('', 200);
    }

    // Pindah santri ke alumni
    public function destroy(Request $req, $id)
    {
        $db_santri = PendataanSantri::find($id);
        $db_alumni = new PendataanAlumni;

        if (empty($db_santri)) {
            return response('Not Found', 404);
        }

        if ($db_alumni->find($id)) {
            return response('Sudah terdaftar sebagai alumni', 400);
        }

        $db_alumni->id_alumni = $db_santri->id_santri;
        $db_alumni->id_ayah = $db_santri->id_ayah;
        $db_alumni->id_ibu = $db_santri->id_ibu;
        $db_alumni->nama = $db_santri->nama;
        $db_alumni->tgl_lahir = $db_santri->tgl_lahir;
        $db_alumni->jenis_kelamin = $db_santri->jenis_kelamin;
        $db_alumni->no_hp = $db_santri->no_hp;
        $db_alumni->alamat = $db_santri->alamat;
        $db_alumni->email = $db_santri->email;
        $db_alumni->nik = $db_santri->nik;
        $db_alumni->photo = $db_santri->photo;
        $db_alumni->tgl_masuk = $db_santri->tgl_masuk;
        $db_alumni->tgl_keluar = $req->date;

        if ($db_alumni->save()) {
            $db_santri->delete();
            return response('Berhasil', 200);
        }

        return response('Gagal', 500);
    }
}
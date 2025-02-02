<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Akademik\Jadwal as AkademikJadwal;
use App\Models\Pendataan\Kelas as PendataanKelas;
use App\Models\Pendataan\Santri as PendataanSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /* View */
    public function index()
    {
        return view('pages.admin.akademik.jadwal', ['type_menu' => 'data_jadwal']);
    }

    public function santri_index()
    {
        // $id_santri = Auth::user()->id_santri;
        $email = Auth::user()->email;
        $santri = PendataanSantri::where('email', '=', $email)->get(['id_kelas'])->first();
        if ($santri) {
            $kelas = PendataanKelas::where('id', $santri->id_kelas)->first(['kelas']);

            if ($kelas) {
                return response()->json(['kelas' => $kelas->kelas]);
            } else {
                return response()->json(['error' => 'Kelas tidak ditemukan'], 404);
            }
        } else {
            return response()->json(['error' => 'Santri tidak ditemukan'], 404);
        }


        $jadwal = AkademikJadwal::where('jadwal.id_kelas', '=', $santri->id_kelas)
            ->leftJoin('kelas', 'kelas.id_kelas', '=', 'jadwal.id_kelas')
            ->leftJoin('mapel', 'mapel.id_mapel', '=', 'jadwal.id_mapel')
            ->leftJoin('pengajar', 'pengajar.id_pengajar', '=', 'jadwal.id_pengajar')
            ->orderBy('jadwal.hari')
            ->get([
                'mapel',
                'pengajar.nama as nama_pengajar',
                'hari',
                'mulai',
                'selesai'
            ]);
        $hari = ['Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu'];

        $data = [
            'jadwal' => $jadwal,
            'kelas' => $kelas->kelas,
            'hari' => $hari
        ];

        return view('pages.santri.jadwal', ['type_menu' => 'data_jadwal', 'data' => $data]);
    }

    /* Controller */
    // Data Tabel
    public function datatable(Request $req)
    {
        $order_column = [
            0 => 'hari',
            1 => 'hari',
            2 => 'kelas',
            3 => 'mapel',
            4 => 'nama',
            5 => 'mulai',
            6 => 'selesai'
        ];

        $recordsTotal = AkademikJadwal::count();

        $jadwal = AkademikJadwal::select([
            'id_jadwal',
            'kelas',
            'mapel',
            'nama',
            'hari',
            'mulai',
            'selesai'
        ])
            ->leftJoin('kelas', 'kelas.id_kelas', '=', 'jadwal.id_kelas')
            ->leftJoin('mapel', 'mapel.id_mapel', '=', 'jadwal.id_mapel')
            ->leftJoin('pengajar', 'pengajar.id_pengajar', '=', 'jadwal.id_pengajar');

        // Search Query
        if ($req->input('search.value') != '') {
            $jadwal = $jadwal->where('mapel', 'like', '%' . $req->input('search.value') . '%', 'or');
            $jadwal = $jadwal->where('kelas', 'like', '%' . $req->input('search.value') . '%', 'or');
            $jadwal = $jadwal->where('nama', 'like', '%' . $req->input('search.value') . '%', 'or');
            $jadwal = $jadwal->where('mulai', 'like', '%' . $req->input('search.value') . '%', 'or');
            $jadwal = $jadwal->where('selesai', 'like', '%' . $req->input('search.value') . '%');
        }

        // Order Query
        $jadwal = $jadwal->orderBy(
            $order_column[$req->input('order.0.column')],
            $req->input('order.0.dir')
        );

        $recordsFiltered = $jadwal->count();

        // Limit Query
        if ($req->input('length') != 1) {
            $jadwal = $jadwal->skip($req->input('start'))->take($req->input('length'));
        }

        $jadwal = $jadwal->get()->toArray();
        $data = [];
        foreach ($jadwal as $i => $r) {
            $sub_array = [];
            $sub_array[] = $i + 1;
            $sub_array[] = $r['hari'];
            $sub_array[] = $r['kelas'];
            $sub_array[] = $r['mapel'];
            $sub_array[] = $r['nama'];
            $sub_array[] = $r['mulai'];
            $sub_array[] = $r['selesai'];
            $sub_array[] = '
          <div class="text-center">
            <button type="button" class="btn btn-success btn-circle btn-sm btn-table btn-edit"
              data-id="' . $r['id_jadwal'] . '">
              <i class="fas fa-pencil"></i></button>
            </button>
            <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
              data-id="' . $r['id_jadwal'] . '">
              <i class="fas fa-trash"></i></button>
            </button>
          </div>
        ';

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
            'in_hari' => 'required',
            'in_kelas' => 'required',
            'in_mapel' => 'required',
            'in_pengajar' => 'required',
            'in_start' => 'required',
            'in_end' => 'required',
        ]);

        $jadwal = new AkademikJadwal();

        // Cek database
        $is_available = $jadwal->where('id_kelas', '=', $req->in_kelas);
        $is_available = $is_available->where('id_mapel', '=', $req->in_mapel);
        $is_available = $is_available->where('id_pengajar', '=', $req->in_pengajar);
        $is_available = $is_available->where('hari', '=', $req->in_hari)->count();

        if ($is_available > 0) {
            return response('Jadwal sudah ada', 422);
        }

        $jadwal->id_kelas = $req->in_kelas;
        $jadwal->id_mapel = $req->in_mapel;
        $jadwal->id_pengajar = $req->in_pengajar;
        $jadwal->hari = $req->in_hari;
        $jadwal->mulai = $req->in_start;
        $jadwal->selesai = $req->in_end;

        if ($jadwal->save()) {
            return response('Sukses', 201);
        }

        return response('Gagal', 500);
    }

    public function show($id)
    {
        $jadwal = AkademikJadwal::select(['id_kelas', 'id_mapel', 'id_pengajar', 'hari', 'mulai', 'selesai']);

        $jadwal = $jadwal->find($id);

        return json_encode($jadwal);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req, [
            'in_hari' => 'required',
            'in_kelas' => 'required',
            'in_mapel' => 'required',
            'in_pengajar' => 'required',
            'in_start' => 'required',
            'in_end' => 'required',
        ]);


        $jadwal = AkademikJadwal::find($id);

        if ($jadwal->count() < 1) {
            return response('Data tak ditemukan', 404);
        }

        $jadwal->id_kelas = $req->in_kelas;
        $jadwal->id_mapel = $req->in_mapel;
        $jadwal->id_pengajar = $req->in_pengajar;
        $jadwal->hari = $req->in_hari;
        $jadwal->mulai = $req->in_start;
        $jadwal->selesai = $req->in_end;

        if ($jadwal->save()) {
            return response('Sukses', 201);
        }

        return response('Gagal', 500);
    }

    public function destroy($id)
    {
        $jadwal = AkademikJadwal::find($id);

        if ($jadwal->delete()) {
            return response('Sukses', 200);
        }

        return response('Gagal', 400);
    }
}

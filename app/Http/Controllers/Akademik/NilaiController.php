<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Akademik\Mapel as AkademikMapel;
use App\Models\Akademik\Nilai as AkademikNilai;
use App\Models\Akademik\Presensi as AkademikPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
  /* View */
  public function index()
  {
    return view('pages.admin.akademik.nilai.index', ['type_menu' => 'data_nilai']);
  }

  public function santri_index()
  {
    $id_santri = Auth::user()->id_santri;

    // Get Nilai
    $sub_tugas = AkademikNilai::selectRaw('id_santri, id_mapel, ROUND(AVG(nilai)) nilai_tugas')
      ->where('tugas', '=', 'tugas', 'and')
      ->where('id_santri', '=', $id_santri)
      ->groupBy(['id_mapel', 'id_santri']);
    $sub_uas = AkademikNilai::select(['id_santri', 'id_mapel', 'nilai as nilai_uas'])
      ->where('tugas', '=', 'uas', 'and')
      ->where('id_santri', '=', $id_santri);
    $sub_uts = AkademikNilai::select(['id_santri', 'id_mapel', 'nilai as nilai_uts'])
      ->where('tugas', '=', 'uts', 'and')
      ->where('id_santri', '=', $id_santri);

    $nilai = AkademikNilai::where('nilai.id_santri', '=', $id_santri)
      ->leftJoin('mapel', 'nilai.id_mapel', '=', 'mapel.id_mapel')
      ->leftJoinSub($sub_tugas, 'tugas', function ($join) {
        $join->on('tugas.id_santri', '=', 'nilai.id_santri', 'and')
          ->on('tugas.id_mapel', '=', 'nilai.id_mapel');
      })
      ->leftJoinSub($sub_uas, 'uas', function ($join) {
        $join->on('uas.id_santri', '=', 'nilai.id_santri', 'and')
          ->on('uas.id_mapel', '=', 'nilai.id_mapel');
      })
      ->leftJoinSub($sub_uts, 'uts', function ($join) {
        $join->on('uts.id_santri', '=', 'nilai.id_santri', 'and')
          ->on('uts.id_mapel', '=', 'nilai.id_mapel');
      })
      ->groupBy(['nilai.id_mapel', 'nilai.id_santri']);

    $nilai = $nilai->get(['mapel', 'nilai_tugas', 'nilai_uas', 'nilai_uts']);

    $sub_ijin = AkademikPresensi::selectRaw('id_santri, count(id_santri) presensi')
      ->where('id_santri', '=', $id_santri, 'and')
      ->where('status', '=', 'ijin')
      ->groupBy(['id_santri']);
    $sub_alpha = AkademikPresensi::selectRaw('id_santri, count(id_santri) presensi')
      ->where('id_santri', '=', $id_santri, 'and')
      ->where('status', '=', 'alpha')
      ->groupBy(['id_santri']);
    $sub_pulang = AkademikPresensi::selectRaw('id_santri, count(id_santri) presensi')
      ->where('id_santri', '=', $id_santri, 'and')
      ->where('status', '=', 'pulang')
      ->groupBy(['id_santri']);
    $sub_sakit = AkademikPresensi::selectRaw('id_santri, count(id_santri) presensi')
      ->where('id_santri', '=', $id_santri, 'and')
      ->where('status', '=', 'sakit')
      ->groupBy(['id_santri']);

    $presensi = AkademikPresensi::select([
      'presensi.id_santri', 'ijin.presensi as ijin', 'alpha.presensi as alpha', 'pulang.presensi as pulang', 'sakit.presensi as sakit'
      ])->where('presensi.id_santri', '=', $id_santri)
      ->leftJoinSub($sub_ijin, 'ijin', function ($join) {
        $join->on('ijin.id_santri', '=', 'presensi.id_santri', 'and');
      })
      ->leftJoinSub($sub_alpha, 'alpha', function ($join) {
        $join->on('alpha.id_santri', '=', 'presensi.id_santri', 'and');
      })
      ->leftJoinSub($sub_pulang, 'pulang', function ($join) {
        $join->on('pulang.id_santri', '=', 'presensi.id_santri', 'and');
      })
      ->leftJoinSub($sub_sakit, 'sakit', function ($join) {
        $join->on('sakit.id_santri', '=', 'presensi.id_santri', 'and');
      })
      ->groupBy('presensi.id_santri');
    $presensi = $presensi->get();

    $data = [
      'nilai' => $nilai,
      'presensi' => $presensi
    ];

    return view('pages.santri.nilai', ['type_menu' => 'data_nilai', 'data' => $data]);
  }

  public function create()
  {
    $mapel = AkademikMapel::get(['id_mapel', 'mapel']);

    $data = [
      'mapel' => $mapel
    ];

    return view('pages.admin.akademik.nilai.add', ['type_menu' => 'data_nilai', 'data' => $data]);
  }

  /* Controller */
  // Data Tabel
  public function datatable(Request $req)
  {
    date_default_timezone_set("Asia/Jakarta");

    $order_column = [
      0 => 'nilai.created_at',
      1 => 'id_santri',
      2 => 'nama',
      3 => 'mapel',
      4 => 'nilai',
      5 => 'id_santri'
    ];

    $recordsTotal = AkademikNilai::count();

    $pengajar = AkademikNilai::selectRaw(
      'id_nilai, nilai.id_santri, santri.nama, nilai, mapel.mapel, tugas, date_format(nilai.created_at, "%d/%m/%Y") tanggal'
    )->leftJoin('santri', 'nilai.id_santri', '=', 'santri.id_santri')
      ->leftJoin('mapel', 'nilai.id_mapel', '=', 'mapel.id_mapel');

    // Search Query
    if ($req->input('search.value') != '') {
      $pengajar = $pengajar->where('nilai.id_santri', 'like', '%' . $req->input('search.value') . '%', 'or');
      $pengajar = $pengajar->where('santri.nama', 'like', '%' . $req->input('search.value') . '%', 'or');
      $pengajar = $pengajar->where('mapel.mapel', 'like', '%' . $req->input('search.value') . '%', 'or');
      $pengajar = $pengajar->where('nilai.tugas', 'like', '%' . $req->input('search.value') . '%', 'or');
    }

    // Order Query
    $pengajar = $pengajar->orderBy(
      $order_column[$req->input('order.0.column')],
      $req->input('order.0.dir')
    );

    $recordsFiltered = $pengajar->count();

    // Limit Query
    if ($req->input('length') != 1) {
      $pengajar = $pengajar->skip($req->input('start'))->take($req->input('length'));
    }

    $pengajar = $pengajar->get()->toArray();
    $data = [];
    foreach ($pengajar as $r) {
      $sub_array = [];
      $sub_array[] = $r['tanggal'];
      $sub_array[] = $r['id_santri'];
      $sub_array[] = $r['nama'];
      $sub_array[] = $r['mapel'];
      $sub_array[] = $r['tugas'];
      $sub_array[] = $r['nilai'];
      $sub_array[] = '
        <div class="text-center">
          <button type="button" class="btn btn-success btn-circle btn-sm btn-table btn-edit"
            data-id="' . $r['id_nilai'] . '">
            <i class="fas fa-pencil"></i></button>
          </button>
          <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
            data-id="' . $r['id_nilai'] . '">
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
    foreach ($req->id as $i => $id) {
      if (isset($req->nilai[$i]) && $req->nilai[$i] !== '') {
        $nilai = new AkademikNilai;

        if ($req->in_tugas == 'uts' || $req->in_tugas == 'uas') {
          $is_available = $nilai->where('id_santri', '=', $req->in_santri, 'and');
          $is_available = $is_available->where('id_mapel', '=', $id, 'and');
          $is_available = $is_available->where('tugas', '=', $req->in_tugas);

          if ($is_available->count() > 0) {
            continue;
          }
        }

        $nilai->id_santri = $req->in_santri;
        $nilai->tugas = $req->in_tugas;
        $nilai->id_mapel = $id;
        $nilai->nilai = $req->nilai[$i];
        $nilai->ket = $req->ket[$i];

        $saved = $nilai->save();

        if (!$saved) {
          return response('Ada yang gagal nih', 500);
        }
      }
    }
  }

  public function show($id)
  {
    $pengajar = AkademikNilai::select([
      'nilai.id_santri', 'santri.nama', 'mapel.mapel', 'tugas', 'nilai', 'ket'
    ])->leftJoin('santri', 'santri.id_santri', '=', 'nilai.id_santri')
      ->leftJoin('mapel', 'mapel.id_mapel', '=', 'nilai.id_mapel');

    $pengajar = $pengajar->find($id);

    return json_encode($pengajar);
  }

  public function destroy($id)
  {
    $pengajar = AkademikNilai::find($id);

    if ($pengajar->delete()) {
      return response('Sukses', 200);
    }

    return response('Gagal', 400);
  }

  public function update(Request $req, $id)
  {
    $this->validate($req, [
      'in_nilai' => 'required',
    ]);

    $pengajar = AkademikNilai::find($id);

    if ($pengajar->count() < 1) {
      return response('Data tak ditemukan', 404);
    }

    $pengajar->nilai = $req->in_nilai;
    $pengajar->ket = $req->in_ket;

    if ($pengajar->save()) {
      return response('Sukses', 200);
    }

    return response('Gagal', 400);
  }
}

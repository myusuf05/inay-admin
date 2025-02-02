<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Akademik\Presensi as AkademikPresensi;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
  public function index()
  {
    return view('pages.admin.akademik.presensi', ['type_menu' => 'data_presensi']);
  }

  // Data Tabel
  public function datatable(Request $req)
  {
    $order_column = [
      0 => 'tanggal',
      1 => 'nama',
      2 => 'kelas',
      3 => 'status',
      4 => 'waktu',
      5 => 'id_santri'
    ];

    $recordsTotal = AkademikPresensi::count();

    $presensi = AkademikPresensi::select([
      'santri.id_santri', 'santri.nama', 'kelas', 'status', 'tanggal', 'id_presensi', 'waktu'
    ])->leftJoin('santri', 'presensi.id_santri', '=', 'santri.id_santri')
      ->leftJoin('kelas', 'santri.id_kelas', '=', 'kelas.id_kelas');

    // Search Query
    if ($req->input('search.value') != '') {
      $presensi = $presensi->where('santri.id_santri', 'like', '%' . $req->input('search.value') . '%', 'or');
      $presensi = $presensi->where('santri.nama', 'like', '%' . $req->input('search.value') . '%', 'or');
      $presensi = $presensi->where('kelas', 'like', '%' . $req->input('search.value') . '%', 'or');
      $presensi = $presensi->where('status', 'like', '%' . $req->input('search.value') . '%', 'or');
    }

    // Order Query
    $presensi = $presensi->orderBy(
      $order_column[$req->input('order.0.column')],
      $req->input('order.0.dir')
    );

    $recordsFiltered = $presensi->count();

    // Limit Query
    if ($req->input('length') != 1) {
      $presensi = $presensi->skip($req->input('start'))->take($req->input('length'));
    }

    $presensi = $presensi->get()->toArray();
    $data = [];
    foreach ($presensi as $i => $r) {
      $sub_array = [];
      $sub_array[] = $r['tanggal'];
      $sub_array[] = $r['id_santri'];
      $sub_array[] = $r['nama'];
      $sub_array[] = $r['kelas'];
      $sub_array[] = ucwords($r['status']);
      $sub_array[] = ucwords($r['waktu']);
      $sub_array[] = '
        <div class="text-center">
          <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
            data-id="' . $r['id_presensi'] . '">
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
      'in_santri' => 'required',
      'in_waktu' => 'required',
      'in_status' => 'required',
      'in_date' => 'required',
      'in_lama' => 'required'
    ]);

    for ($i = 0; $i < (int) $req->in_lama; $i++) {
      $presensi = new AkademikPresensi();

      $is_available = $presensi->where('id_santri', '=', $req->in_santri, 'and');
      $is_available = $is_available->where('waktu', '=', $req->in_waktu, 'and');
      $is_available = $is_available->where('tanggal', '=', $req->in_date, 'and')->count();

      if ($is_available < 1) {
        $presensi->id_santri = $req->in_santri;
        $presensi->waktu = $req->in_waktu;
        $presensi->status = $req->in_status;

        $presensi->tanggal = date("Y-m-d", strtotime("+" . $i . " day", strtotime($req->in_date)));

        $saved = $presensi->save();

        if (!$saved) {
          return response('Gagal', 500);
        }
      }
    }

    return response('Sukses', 200);
  }

  public function destroy($id)
  {
    $pengajar = AkademikPresensi::find($id);

    if ($pengajar->delete()) {
      return response('Sukses', 200);
    }

    return response('Gagal', 400);
  }
}

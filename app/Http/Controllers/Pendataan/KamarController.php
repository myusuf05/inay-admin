<?php

namespace App\Http\Controllers\Pendataan;

use App\Http\Controllers\Controller;
use App\Models\Pendataan\Kamar as PendataanKamar;
use App\Models\Pendataan\Santri as PendataanSantri;
use Illuminate\Http\Request;

class KamarController extends Controller
{
  public function get_data(Request $req)
  {
    $order_column = [
      0 => 'kamar.id_kamar',
      1 => 'kamar',
      2 => 'area'
    ];

    $recordsTotal = PendataanKamar::count();

    $rooms = PendataanKamar::selectRaw(
      'kamar.id_kamar, kamar, area, maks, count(santri.id_santri) as jumlah'
    );

    $rooms = $rooms->leftJoin('santri', 'santri.id_kamar', '=', 'kamar.id_kamar');

    // Search Query
    if ($req->input('search.value') != '') {
      $rooms = $rooms->where('kamar', 'like', '%' . $req->input('search.value') . '%');
    }

    // Order Query
    $rooms = $rooms->orderBy(
      $order_column[$req->input('order.0.column')],
      $req->input('order.0.dir')
    );

    $rooms = $rooms->groupBy('kamar.id_kamar');

    $recordsFiltered = $rooms->count();

    // Limit Query
    if ($req->input('length') != 1) {
      $rooms = $rooms->skip($req->input('start'))->take($req->input('length'));
    }

    $rooms = $rooms->get()->toArray();
    $data = [];
    foreach ($rooms as $i => $r) {
      $sub_array = [];
      $sub_array[] = $i + 1;
      $sub_array[] = $r['kamar'];
      $sub_array[] = $r['area'];
      $sub_array[] = $r['jumlah'] . '/' . $r['maks'];
      $sub_array[] = '
        <div class="text-center">
          <a href="/pendataan/kamar/detail/' . $r['id_kamar'] . '" class="btn btn-info btn-circle btn-sm btn-table btn-see">
            <i class="fas fa-eye"></i></a>
          </button>
          <button type="button" class="btn btn-success btn-circle btn-sm btn-table btn-edit"
            data-id="' . $r['id_kamar'] . '">
            <i class="fas fa-pencil"></i></button>
          </button>
          <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
            data-id="' . $r['id_kamar'] . '">
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

  public function get_list()
  {
    $db = PendataanKamar::selectRaw('kamar.id_kamar, kamar, maks, count(id_santri) as jumlah')
      ->leftJoin('santri', 'kamar.id_kamar', '=', 'santri.id_kamar')
      ->groupBy('kamar.id_kamar');


    return json_encode($db->get());
  }

  public function index()
  {
    return view('pages.admin.pendataan.kamar.index', ['type_menu' => 'data_kamar']);
  }

  public function see_occupants($id)
  {
    return view('pages.admin.pendataan.kamar.see', ['type_menu' => 'data_kamar']);
  }

  public function get_occupants(Request $req, $id)
  {
    $order_column = [
      0 => 'id_santri',
      1 => 'nama',
      2 => 'kelas'
    ];

    $recordsTotal = PendataanSantri::where('id_kamar', '=', $id)->count();

    $santri = PendataanSantri::select('id_santri', 'nama', 'kelas')
    ->leftJoin('kelas', 'santri.id_kelas', '=', 'kelas.id_kelas')
    ->where('id_kamar', '=', $id);

    // Search Query
    if ($req->input('search.value') != '') {
      $santri = $santri->having('id_santri', 'like', '%' . $req->input('search.value') . '%');
      $santri = $santri->having('nama', 'like', '%' . $req->input('search.value') . '%', 'or');
      $santri = $santri->having('kelas', 'like', '%' . $req->input('search.value') . '%', 'or');
    }

    // Order Query
    $santri = $santri->orderBy(
      $order_column[$req->input('order.0.column')],
      $req->input('order.0.dir')
    );

    $recordsFiltered = $santri->count();

    // Limit Query
    if ($req->input('length') != 1) {
      $santri = $santri->skip($req->input('start'))->take($req->input('length'));
    }

    $santri = $santri->get()->toArray();
    $data = [];
    foreach ($santri as $i => $r) {
      $sub_array = [];
      $sub_array[] = $r['id_santri'];
      $sub_array[] = $r['nama'];
      $sub_array[] = $r['kelas'];
      $sub_array[] = '
        <div class="text-center">
          <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
            data-id="' . $r['id_santri'] . '">
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

  public function delete_occupants(Request $req, $id) {
    $santri = PendataanSantri::where('id_santri', '=', $req->id)->first();

    $santri->id_kamar = null;
    if($santri->save()) {
      return response('Sukses Hapus', 200);
    }

    return response('Gagal hapus', 500);
  }

  public function add_occupants(Request $req) {
    $kamar = PendataanKamar::find($req->id_kamar);

    $santri = PendataanSantri::where('id_kamar', '=', $req->id_kamar)->count();

    if((int) $santri >= (int) $kamar->maks) {
      return response('Kamar penuh', 400);
    }

    $santri = PendataanSantri::where('id_santri', '=', $req->in_santri)->first();
    $santri->id_kamar = $req->id_kamar;

    if($santri->save()) {
      return response('Sukses tambah penghuni', 200);
    }

    return response('Gagal', 500);
  }

  public function store(Request $req)
  {
    $this->validate($req, [
      'in_name' => 'required|min:5',
      'in_area' => 'required|max:1',
      'in_maks' => 'required'
    ]);

    $rooms = new PendataanKamar;

    // Cek database
    $is_available = $rooms->where('kamar', '=', $req->in_name, 'and');
    $is_available = $is_available->where('area', '=', $req->in_area)->count();

    if ($is_available > 0) {
      return response('Nama kamar sudah ada', 422);
    }

    $rooms->kamar = $req->in_name;
    $rooms->area = $req->in_area;
    $rooms->maks = $req->in_maks;
    if($rooms->save()) {
      return response('Sukses', 201);
    }
    
    return response('Gagal', 500);
  }

  public function show($id)
  {
    $rooms = PendataanKamar::select(['kamar', 'area', 'maks']);

    $rooms = $rooms->find($id);

    return json_encode($rooms);
  }

  public function update(Request $req, $id)
  {
    $this->validate($req, [
      'in_name' => 'required|min:5',
      'in_area' => 'required|max:1',
      'in_maks' => 'required'
    ]);

    $rooms = PendataanKamar::find($id);

    if ($rooms->count() < 1) {
      return response('Data tak ditemukan', 404);
    }

    $rooms->kamar = $req->in_name;
    $rooms->area = $req->in_area;
    $rooms->maks = $req->in_maks;
    
    if ($rooms->save()) {
      return response('Sukses', 200);
    }

    return response('Gagal', 400);
  }

  public function destroy($id)
  {
    $rooms = PendataanKamar::find($id);
    $santri = PendataanSantri::where('id_kamar', '=', $id)->count();

    if($santri > 0) {
      return response('Tidak bisa dihapus karena masih ada isinya', 400);
    }

    if ($rooms->delete()) {
      return response('Sukses', 200);
    }

    return response('Gagal', 400);
  }
}


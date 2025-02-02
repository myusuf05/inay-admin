<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Akademik\Mapel as AkademikMapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
  public function index()
  {
    return view('pages.admin.akademik.mapel', ['type_menu' => 'data_mapel']);
  }

  public function get_list() {
    $db = AkademikMapel::get(['id_mapel', 'mapel']);
    
    return json_encode($db);
  }

  // Data Tabel
  public function datatable(Request $req)
  {
    $order_column = [
      0 => 'mapel',
      1 => 'mapel'
    ];

    $recordsTotal = AkademikMapel::count();

    $mapel = AkademikMapel::select([
      'id_mapel', 'mapel'
    ]);

    // Search Query
    if ($req->input('search.value') != '') {
      $mapel = $mapel->where('mapel', 'like', '%' . $req->input('search.value') . '%');
    }

    // Order Query
    $mapel = $mapel->orderBy(
      $order_column[$req->input('order.0.column')],
      $req->input('order.0.dir')
    );

    $recordsFiltered = $mapel->count();

    // Limit Query
    if ($req->input('length') != 1) {
      $mapel = $mapel->skip($req->input('start'))->take($req->input('length'));
    }

    $mapel = $mapel->get()->toArray();
    $data = [];
    foreach ($mapel as $i => $r) {
      $sub_array = [];
      $sub_array[] = $i + 1;
      $sub_array[] = $r['mapel'];
      $sub_array[] = '
        <div class="text-center">
          <button type="button" class="btn btn-success btn-circle btn-sm btn-table btn-edit"
            data-id="' . $r['id_mapel'] . '">
            <i class="fas fa-pencil"></i></button>
          </button>
          <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
            data-id="' . $r['id_mapel'] . '">
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
      'in_mapel' => 'required|min:5'
    ]);

    $mapel = new AkademikMapel();

    // Cek database
    $is_available = $mapel->where('mapel', '=', $req->in_mapel)->count();

    if ($is_available > 0) {
      return response('Nama kamar sudah ada', 422);
    }

    $mapel->mapel = $req->in_mapel;

    if ($mapel->save()) {
      return response('Sukses', 201);
    }

    return response('Gagal', 500);
  }

  public function show($id)
  {
    $mapel = AkademikMapel::select(['mapel']);

    $mapel = $mapel->find($id);

    return json_encode($mapel);
  }

  public function update(Request $req, $id)
  {
    $this->validate($req, [
      'in_mapel' => 'required|min:3',
    ]);

    $rooms = AkademikMapel::find($id);

    if ($rooms->count() < 1) {
      return response('Data tak ditemukan', 404);
    }

    $rooms->mapel = $req->in_mapel;

    if ($rooms->save()) {
      return response('Sukses', 200);
    }

    return response('Gagal', 400);
  }

  public function destroy($id)
  {
    $mapel = AkademikMapel::find($id);

    if ($mapel->delete()) {
      return response('Sukses', 200);
    }

    return response('Gagal', 400);
  }
}

<?php

namespace App\Http\Controllers\Pendataan;

use App\Http\Controllers\Controller;
use App\Models\Pendataan\Kelas as PendataanKelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
  public function get_data(Request $req)
  {
    $order_column = [
      0 => 'id_kelas',
      1 => 'kelas'
    ];

    $recordsTotal = PendataanKelas::count();

    $kelas = PendataanKelas::select([
      'id_kelas', 'kelas'
    ]);

    // Search
    if ($req->input('search.value') != '') {
      $kelas = $kelas->where('kelas', 'like', '%' . $req->input('search.value') . '%');
    }

    // Order Query
    $kelas = $kelas->orderBy(
      $order_column[$req->input('order.0.column')],
      $req->input('order.0.dir')
    );

    $recordsFiltered = $kelas->count();

    // Limit Query
    if ($req->input('length') != 1) {
      $kelas = $kelas->skip($req->input('start'))->take($req->input('length'));
    }

    $kelas = $kelas->get()->toArray();
    $data = [];
    foreach ($kelas as $i => $r) {
      $sub_array = [];
      $sub_array[] = $i + 1;
      $sub_array[] = $r['kelas'];
      $sub_array[] = '
          <div class="text-center">
            <button type="button" class="btn btn-success btn-circle btn-sm btn-table btn-edit"
              data-id="' . $r['id_kelas'] . '">
              <i class="fas fa-pencil"></i></button>
            </button>
            <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
              data-id="' . $r['id_kelas'] . '">
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

  public function get_list() {
    $db = PendataanKelas::get(['id_kelas', 'kelas']);
    
    return json_encode($db);
  }

  public function index()
  {
    return view('pages.admin.pendataan.kelas', ['type_menu' => 'data_kelas']);
  }

  public function store(Request $req)
  {
    $this->validate($req, [
      'in_kelas' => 'required|min:5'
    ]);

    $kelas = PendataanKelas::select([
      'id_kelas', 'kelas'
    ]);

    // Cek database
    $kelas = $kelas->where('kelas', '=', $req->in_kelas)->count();

    if ($kelas > 0) {
      return response('', 422);
    }

    $kelas = new PendataanKelas;
    $kelas->kelas = $req->in_kelas;
    $kelas->save();

    if($kelas->isDirty()) {
      return response('', 400);
    }

    return response('', 201);
  }

  public function show($id)
  {
    $kelas = PendataanKelas::select(['kelas']);

    $kelas = $kelas->find($id);

    return json_encode($kelas);
  }  

  public function update(Request $req, $id)
  {
    $this->validate($req, [
      'in_kelas' => 'required|min:5'
    ]);

    $kelas = PendataanKelas::find($id);

    if($kelas->count() < 1) {
      return response('', 404);
    }
    
    $kelas->kelas = $req->in_kelas;
    $kelas->save();

    if($kelas->isDirty()) {
      return response('', 400);
    }

    return response('', 201);
  }

  public function destroy($id) {
    $kelas = PendataanKelas::find($id);

    if($kelas->delete()) {
      return response('', 200);
    }

    return response('', 400);
  }

}

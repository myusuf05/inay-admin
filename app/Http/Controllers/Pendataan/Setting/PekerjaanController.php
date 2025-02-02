<?php

namespace App\Http\Controllers\Pendataan\Setting;

use App\Http\Controllers\Controller;
use App\Models\Pendataan\Setting\Pekerjaan as PendataanPekerjaan;
use Illuminate\Http\Request;

class PekerjaanController extends Controller
{
  // DataTable
  public function get_data(Request $req)
  {
    $order_column = [
      0 => 'pekerjaan',
      1 => 'is_aktif',
    ];

    $db = PendataanPekerjaan::select([
      'pekerjaan', 'is_aktif', 'id_pekerjaan'
    ]);

    $recordsTotal = $db->count();

    // Search Query
    if ($req->input('search.value') != '') {
      $db = $db->where('pekerjaan', 'like', '%' . $req->input('search.value') . '%');
    }

    // Order Query
    $db = $db->orderBy(
      $order_column[$req->input('order.0.column')],
      $req->input('order.0.dir')
    );

    $recordsFiltered = $db->count();

    // Limit Query
    if ($req->input('length') != 1) {
      $db = $db->skip($req->input('start'))->take($req->input('length'));
    }

    $db = $db->get()->toArray();

    $data = [];
    foreach ($db as $r) {
      $sub_array = [];
      $sub_array[] = $r['pekerjaan'];
      $sub_array[] = $r['is_aktif'] == 1 ? '
          <button type="button" class="btn btn-success btn-circle btn-sm btn-active"
            data-id="' . $r['id_pekerjaan'] . '"> Aktif </button>
        ' : '
          <button type="button" class="btn btn-danger btn-circle btn-sm btn-active"
            data-id="' . $r['id_pekerjaan'] . '"> Non Aktif </button>
        ';
      $sub_array[] = '
          <div class="text-center">
            <button type="button" class="btn btn-success btn-circle btn-sm btn-table btn-edit"
              data-id="' . $r['id_pekerjaan'] . '">
              <i class="fas fa-pencil"></i></button>
            </button>
            <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
              data-id="' . $r['id_pekerjaan'] . '">
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

  public function get_all() {
    $db = PendataanPekerjaan::where('is_aktif', '=', '1')->get(['id_pekerjaan', 'pekerjaan']);
    
    return json_encode($db);
  }
  
  public function store(Request $req)
  {
    $this->validate($req, [
      'in_setting' => 'required|min:5'
    ]);

    $db = new PendataanPekerjaan;

    $is_available = $db->where('pekerjaan', '=', $req->in_setting)->count();

    if ($is_available < 1) {
      $db->pekerjaan = $req->in_setting;
      $db->save();

      return response('', 201);
    }

    return response('', 422);
  }

  public function destroy($id)
  {
    $db = PendataanPekerjaan::findOrFail((int)$id)->delete();

    if ($db) {
      return response('', 200);
    }

    return response(500);
  }

  public function show($id)
  {
    $db = PendataanPekerjaan::select(['pekerjaan as setting_value']);

    $db = $db->findOrFail($id);

    return json_encode($db);
  }

  public function update(Request $req, $id)
  {
    $this->validate($req, [
      'in_setting' => 'required|min:3'
    ]);

    $db = PendataanPekerjaan::findOrFail($id);

    $db->pekerjaan = $req->in_setting;
    $db->save();

    if ($db->isDirty()) {
      return response('', 400);
    }

    return response('', 201);
  }

  public function active($id)
  {
    $db = PendataanPekerjaan::findOrFail(intval($id));

    $db->is_aktif = $db->is_aktif == '0' ? '1' : '0';
    $db->save();

    if ($db->isDirty()) {
      return response('', 400);
    }

    return response('', 200);
  }
}

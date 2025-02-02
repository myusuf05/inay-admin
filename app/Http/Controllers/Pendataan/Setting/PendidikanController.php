<?php

namespace App\Http\Controllers\Pendataan\Setting;

use App\Http\Controllers\Controller;
use App\Models\Pendataan\Setting\Pendidikan as PendataanPendidikan;
use Illuminate\Http\Request;

class PendidikanController extends Controller
{
  public function get_data(Request $req)
  {
    $order_column = [
      0 => 'pendidikan',
      1 => 'is_aktif',
    ];

    $db = PendataanPendidikan::select([
      'id_pendidikan', 'pendidikan', 'is_aktif'
    ]);

    $recordsTotal = $db->count();

    // Search Query
    if ($req->input('search.value') != '') {
      $db = $db->where('pendidikan', 'like', '%' . $req->input('search.value') . '%');
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
      $sub_array[] = $r['pendidikan'];
      $sub_array[] = $r['is_aktif'] == 1 ? '
          <button type="button" class="btn btn-success btn-circle btn-sm btn-active"
            data-id="' . $r['id_pendidikan'] . '"> Aktif </button>
        ' : '
          <button type="button" class="btn btn-danger btn-circle btn-sm btn-active"
            data-id="' . $r['id_pendidikan'] . '"> Non Aktif </button>
        ';
      $sub_array[] = '
          <div class="text-center">
            <button type="button" class="btn btn-success btn-circle btn-sm btn-table btn-edit"
              data-id="' . $r['id_pendidikan'] . '">
              <i class="fas fa-pencil"></i>
            </button>
            <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
              data-id="' . $r['id_pendidikan'] . '">
              <i class="fas fa-trash"></i>
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
    $db = PendataanPendidikan::where('is_aktif', '=', '1')->get(['id_pendidikan', 'pendidikan']);
    
    return json_encode($db);
  }
  

  public function store(Request $req)
  {
    $this->validate($req, [
      'in_setting' => 'required|min:2'
    ]);

    $db = new PendataanPendidikan;

    $is_available = $db->where('pendidikan', '=', $req->in_setting)->count();

    if ($is_available < 1) {
      $db->pendidikan = $req->in_setting;
      $db->save();

      return response('', 201);
    }

    return response('', 422);
  }

  public function destroy($id)
  {
    $db = PendataanPendidikan::find($id);

    if($db->delete()) {
      return response('', 200);
    }

    return response('', 400);
  }

  public function show($id)
  {
    $db = PendataanPendidikan::select(['pendidikan as setting_value']);

    $db = $db->findOrFail($id);

    return json_encode($db);
  }

  public function update(Request $req, $id)
  {
    $this->validate($req, [
      'in_setting' => 'required|min:2'
    ]);
    
    $db = PendataanPendidikan::findOrFail($id);
    
    $db->pendidikan = $req->in_setting;
    $db->save();

    if($db->isDirty()) {
      return response('', 400);
    }

    return response('', 201);
  }

  public function active($id, Request $req)
  {
    $db = PendataanPendidikan::findOrFail(intval($id));

    $db->is_aktif = $db->is_aktif == '0' ? '1' : '0';
    $db->save();

    if($db->isDirty()) {
      return response('', 400);
    }

    return response('', 200);
  }
}

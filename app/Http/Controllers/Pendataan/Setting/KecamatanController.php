<?php

namespace App\Http\Controllers\Pendataan\Setting;

use App\Http\Controllers\Controller;
use App\Models\Pendataan\Setting\Kecamatan as PendataanKecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
  public function get_data(Request $req)
  {
    $order_column = [
      0 => 'kecamatan',
    ];

    $kec = PendataanKecamatan::select([
      'kecamatan', 'id_kecamatan'
    ]);

    $recordsTotal = $kec->count();

    // Search Query
    if ($req->input('search.value') != '') {
      $kec = $kec->where('kecamatan', 'like', '%' . $req->input('search.value') . '%');
    }

    // Order Query
    $kec = $kec->orderBy(
      $order_column[$req->input('order.0.column')],
      $req->input('order.0.dir')
    );

    $recordsFiltered = $kec->count();

    // Limit Query
    if ($req->input('length') != 1) {
      $kec = $kec->skip($req->input('start'))->take($req->input('length'));
    }

    $kec = $kec->get()->toArray();

    $data = [];
    foreach ($kec as $r) {
      $sub_array = [];
      $sub_array[] = $r['kecamatan'];
      $sub_array[] = '
            <div class="text-center">
              <button type="button" class="btn btn-success btn-circle btn-sm btn-table btn-edit"
                data-id="' . $r['id_kecamatan'] . '">
                <i class="fas fa-pencil"></i>
              </button>
              <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
                data-id="' . $r['id_kecamatan'] . '">
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
}

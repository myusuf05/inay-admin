<?php

namespace App\Http\Controllers\Pendataan\Setting;

use App\Http\Controllers\Controller;
use App\Models\Pendataan\Setting\Provinsi as PendataanProvinsi;
use Illuminate\Http\Request;

class ProvinsiController extends Controller
{
    public function get_data(Request $req)
    {
      $order_column = [
        0 => 'provinsi',
      ];
  
      $db = PendataanProvinsi::select([
        'provinsi', 'id_provinsi'
      ]);

      $recordsTotal = $db->count();
  
      // Search Query
      if ($req->input('search.value') != '') {
        $db = $db->where('provinsi', 'like', '%' . $req->input('search.value') . '%');
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
        $sub_array[] = $r['provinsi'];
        $sub_array[] = '
          <div class="text-center">
            <button type="button" class="btn btn-success btn-circle btn-sm btn-table btn-edit"
              data-id="' . $r['id_provinsi'] . '">
              <i class="fas fa-pencil"></i>
            </button>
            <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
              data-id="' . $r['id_provinsi'] . '">
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

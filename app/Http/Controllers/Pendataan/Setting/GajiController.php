<?php

namespace App\Http\Controllers\Pendataan\Setting;

use App\Http\Controllers\Controller;
use App\Models\Pendataan\Setting\Gaji as PendataanGaji;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    public function get_data(Request $req)
    {
        $order_column = [
            0 => 'gaji',
            1 => 'is_aktif',
        ];

        $db = PendataanGaji::select([
            'id_gaji',
            'gaji',
            'is_aktif'
        ]);

        $recordsTotal = $db->count();

        // Search Query
        if ($req->input('search.value') != '') {
            $db = $db->where('gaji', 'like', '%' . $req->input('search.value') . '%');
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
            $sub_array[] = $r['gaji'];
            $sub_array[] = $r['is_aktif'] == 1 ? '
          <button type="button" class="btn btn-success btn-circle btn-sm btn-active"
            data-id="' . $r['id_gaji'] . '"> Aktif </button>
        ' : '
          <button type="button" class="btn btn-danger btn-circle btn-sm btn-active"
            data-id="' . $r['id_gaji'] . '"> Non Aktif </button>
        ';
            $sub_array[] = '
          <div class="text-center">
            <button type="button" class="btn btn-success btn-circle btn-sm btn-table btn-edit"
              data-id="' . $r['id_gaji'] . '">
              <i class="fas fa-pencil"></i></button>
            </button>
            <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
              data-id="' . $r['id_gaji'] . '">
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

    public function get_all()
    {
        $db = PendataanGaji::where('is_aktif', '=', '1')->get(['id_gaji', 'gaji']);

        return json_encode($db);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'in_setting' => 'required|min:3'
        ]);
        $db = new PendataanGaji;

        $is_available = $db->where('gaji', '=', $req->in_setting)->count();
        if ($is_available < 1) {
            $db->gaji = $req->in_setting;
            $db->save();

            return response('', 201);
        }

        return response('', 422);
    }

    public function destroy($id)
    {
        $db = PendataanGaji::findOrFail((int)$id)->delete();

        if ($db) {
            return response('', 200);
        }

        return response(500);
    }

    public function show($id)
    {
        $db = PendataanGaji::select(['gaji as setting_value']);

        $db = $db->findOrFail($id);

        return json_encode($db);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req, [
            'in_setting' => 'required|min:3'
        ]);

        $db = PendataanGaji::findOrFail($id);

        $db->gaji = $req->in_setting;
        $db->save();

        if ($db->isDirty()) {
            return response('', 400);
        }

        return response('', 201);
    }

    public function active($id, Request $req)
    {
        $db = PendataanGaji::findOrFail(intval($id));

        $db->is_aktif = $db->is_aktif == '0' ? '1' : '0';
        $db->save();

        if ($db->isDirty()) {
            return response('', 400);
        }

        return response('', 200);
    }
}
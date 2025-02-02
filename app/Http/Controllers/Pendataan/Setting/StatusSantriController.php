<?php

namespace App\Http\Controllers\Pendataan\Setting;

use App\Http\Controllers\Controller;
use App\Models\Pendataan\Setting\StatusSantri as PendataanStatusSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusSantriController extends Controller
{
    private $table = 'statuss';

    public function get_data(Request $req)
    {
        $order_column = [
            0 => 'status',
            1 => 'is_aktif',
        ];

        $db = PendataanStatusSantri::select([
            'id_gaji',
            'gaji',
            'is_aktif'
        ]);

        $recordsTotal = $db->count();

        // Get Query
        $rooms = $db->select([
            'status',
            'is_aktif',
            'id_status'
        ]);

        // Search Query
        if ($req->input('search.value') != '') {
            $rooms = $rooms->where('status', 'like', '%' . $req->input('search.value') . '%');
        }

        // Order Query
        $rooms = $rooms->orderBy(
            $order_column[$req->input('order.0.column')],
            $req->input('order.0.dir')
        );

        $recordsFiltered = $rooms->count();

        // Limit Query
        if ($req->input('length') != 1) {
            $rooms = $rooms->skip($req->input('start'))->take($req->input('length'));
        }

        $rooms = $rooms->get()->toArray();

        $data = [];
        foreach ($rooms as $r) {
            $sub_array = [];
            $sub_array[] = $r['status'];
            $sub_array[] = $r['is_aktif'] == 1 ? '
          <button type="button" class="btn btn-success btn-circle btn-sm btn-active"
            data-id="' . $r['id_status'] . '"> Aktif </button>
        ' : '
          <button type="button" class="btn btn-danger btn-circle btn-sm btn-active"
            data-id="' . $r['id_status'] . '"> Non Aktif </button>
        ';
            $sub_array[] = '
          <div class="text-center">
            <button type="button" class="btn btn-success btn-circle btn-sm btn-table btn-edit"
              data-id="' . $r['id_status'] . '">
              <i class="fas fa-pencil"></i></button>
            </button>
            <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
              data-id="' . $r['id_status'] . '">
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
        $db = PendataanStatusSantri::where('is_aktif', '=', '1')->get(['id_status', 'status']);

        return json_encode($db);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'in_setting' => 'required|min:5'
        ]);

        $db = new PendataanStatusSantri;

        $is_available = $db->where('status', '=', $req->in_setting)->count();

        if ($is_available < 1) {
            $db->status = $req->in_setting;
            $db->save();

            return response('', 201);
        }

        return response('', 422);
    }

    public function destroy($id)
    {
        $db = PendataanStatusSantri::findOrFail((int)$id)->delete();

        if ($db) {
            return response('', 200);
        }

        return response(500);
    }

    public function show($id)
    {
        $db = PendataanStatusSantri::select(['status as setting_value']);

        $db = $db->findOrFail($id);

        return json_encode($db);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req, [
            'in_setting' => 'required|min:3'
        ]);

        $db = PendataanStatusSantri::findOrFail($id);

        $db->status = $req->in_setting;
        $db->save();

        if ($db->isDirty()) {
            return response('', 400);
        }

        return response('', 201);
    }

    public function active($id)
    {
        $db = PendataanStatusSantri::findOrFail(intval($id));

        $db->is_aktif = $db->is_aktif == '0' ? '1' : '0';
        $db->save();

        if ($db->isDirty()) {
            return response('', 400);
        }

        return response('', 200);
    }
}
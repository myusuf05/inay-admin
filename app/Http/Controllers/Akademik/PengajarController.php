<?php

namespace App\Http\Controllers\Akademik;

use App\Http\Controllers\Controller;
use App\Models\Akademik\Pengajar as AkademikPengajar;
use Illuminate\Http\Request;

class PengajarController extends Controller
{
    public function index()
    {
        return view('pages.admin.akademik.pengajar', ['type_menu' => 'data_pengajar']);
    }

    // Data Tabel
    public function datatable(Request $req)
    {
        $order_column = [
            0 => 'id_pengajar',
            1 => 'nama',
            2 => 'no_hp'
        ];

        $recordsTotal = AkademikPengajar::count();

        $pengajar = AkademikPengajar::select([
            'id_pengajar',
            'nama',
            'no_hp'
        ]);

        // Search Query
        if ($req->input('search.value') != '') {
            $pengajar = $pengajar->where('id_pengajar', 'like', '%' . $req->input('search.value') . '%', 'or');
            $pengajar = $pengajar->where('nama', 'like', '%' . $req->input('search.value') . '%', 'or');
            $pengajar = $pengajar->where('no_hp', 'like', '%' . $req->input('search.value') . '%', 'or');
        }

        // Order Query
        $pengajar = $pengajar->orderBy(
            $order_column[$req->input('order.0.column')],
            $req->input('order.0.dir')
        );

        $recordsFiltered = $pengajar->count();

        // Limit Query
        if ($req->input('length') != 1) {
            $pengajar = $pengajar->skip($req->input('start'))->take($req->input('length'));
        }

        $pengajar = $pengajar->get()->toArray();
        $data = [];
        foreach ($pengajar as $r) {
            $sub_array = [];
            $sub_array[] = $r['id_pengajar'];
            $sub_array[] = $r['nama'];
            $sub_array[] = $r['no_hp'];
            $sub_array[] = '
        <div class="text-center">
          <button type="button" class="btn btn-success btn-circle btn-sm btn-table btn-edit"
            data-id="' . $r['id_pengajar'] . '">
            <i class="fas fa-pencil"></i></button>
          </button>
          <button type="button" class="btn btn-danger btn-circle btn-sm btn-table btn-delete"
            data-id="' . $r['id_pengajar'] . '">
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
        $db = AkademikPengajar::selectRaw('id_pengajar, CONCAT(8, LPAD(id_pengajar, 3, 0)) nip, nama')->get();

        return json_encode($db);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'in_nama' => 'required|min:5',
            'in_alamat' => 'required|min:5',
            'in_gender' => 'required',
            'in_hp' => 'required|min:5'
        ]);

        $pengajar = new AkademikPengajar();

        // Cek database
        $is_available = $pengajar->where('nama', '=', $req->in_nama)->count();

        if ($is_available > 0) {
            return response('Nama sudah ada', 422);
        }

        $pengajar->nama = $req->in_nama;
        $pengajar->alamat = $req->in_alamat;
        $pengajar->jenis_kelamin = $req->in_gender;
        $pengajar->no_hp = $req->in_hp;

        if ($pengajar->save()) {
            return response('Sukses', 201);
        }

        return response('Gagal', 500);
    }

    public function show($id)
    {
        $pengajar = AkademikPengajar::select(['nama', 'alamat', 'jns_kelamin', 'no_hp']);

        $pengajar = $pengajar->find($id);

        return json_encode($pengajar);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req, [
            'in_nama' => 'required|min:5',
            'in_alamat' => 'required|min:5',
            'in_gender' => 'required',
            'in_hp' => 'required|min:5'
        ]);

        $pengajar = AkademikPengajar::find($id);

        if ($pengajar->count() < 1) {
            return response('Data tak ditemukan', 404);
        }

        $pengajar->nama = $req->in_nama;
        $pengajar->alamat = $req->in_alamat;
        $pengajar->jenis_kelamin = $req->in_gender;
        $pengajar->no_hp = $req->in_hp;

        if ($pengajar->save()) {
            return response('Sukses', 200);
        }

        return response('Gagal', 400);
    }

    public function destroy($id)
    {
        $pengajar = AkademikPengajar::find($id);

        if ($pengajar->delete()) {
            return response('Sukses', 200);
        }

        return response('Gagal', 400);
    }
}
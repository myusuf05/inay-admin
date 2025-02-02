<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendataan\Santri;
use Illuminate\Http\Request;
use App\Models\User as AdminUser;

class UserController extends Controller
{
    public function get_data(Request $req)
    {
        $order_column = [
            0 => 'id_santri',
            1 => 'nama',
            2 => 'email',
            3 => 'akses',
            4 => 'is_aktif',
        ];

        $recordsTotal = AdminUser::count();

        $rooms = AdminUser::select([
            'id_santri',
            'nama',
            'email',
            'is_aktif',
            'akses'
        ]);

        // Search Query
        if ($req->input('search.value') != '') {
            $rooms = $rooms->where('akses', 'like', '%' . $req->input('search.value') . '%');
            $rooms = $rooms->where('nama', 'like', '%' . $req->input('search.value') . '%', 'or');
            $rooms = $rooms->where('email', 'like', '%' . $req->input('search.value') . '%', 'or');
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
        foreach ($rooms as $i => $r) {
            $sub_array = [];
            $sub_array[] = $r['nama'];
            $sub_array[] = $r['email'];
            $sub_array[] = $r['akses'];
            $sub_array[] = $r['is_aktif'] == 1 ? '
                        <button type="button" class="btn btn-success btn-circle btn-sm btn-active"
                          data-id="' . $r['id_santri'] . '"> Aktif </button>
                      ' : '
                        <button type="button" class="btn btn-danger btn-circle btn-sm btn-active"
                          data-id="' . $r['id_santri'] . '"> Non Aktif </button>
                      ';
            $sub_array[] = '<div class="text-center">
                        <button type="button" class="btn btn-success btn-circle btn-sm btn-table btn-edit"
                          data-id="' . $r['id_santri'] . '">
                          <i class="fas fa-pencil"></i></button>
                        </button>
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

    public function index()
    {
        return view('pages.admin.user.user', ['type_menu' => 'user_list']);
    }

    public function store(Request $req)
    {
        $this->validate($req, [
            'in_name' => 'required',
            'in_email' => 'required|email',
            'in_password' => 'required|min:6|max:16',
            'in_akses' => 'required'
        ]);

        // $email = Santri::select('email')->get();

        // return view('pages.admin.user.add', ['type_menu' => 'user_list', 'email' => $email]);
        $santri = Santri::where('email', $req->in_email)->first();

        if ($req->in_akses == 'santri') {

            if ($santri) {
                $user = new AdminUser;
                $user->nama = $req->in_name;
                $user->email = $req->in_email;
                $user->password = bcrypt($req->in_password);
                $user->akses = $req->in_akses;
                $user->id_santri = $santri->id_santri;
                $user->is_aktif = 1; // Set default aktif
                $user->save();
                return response('User Berhasil dibuat', 201);
            }
            return response('Santri Tidak ditemukan', 404);
        }

        $is_available = AdminUser::where('email', '=', $req->in_email)->count();

        if ($is_available < 1) {
            $rooms = new AdminUser;
            $rooms->nama = $req->in_name;
            $rooms->email = $req->in_email;
            $rooms->password = bcrypt($req->in_password);
            $rooms->akses = $req->in_akses;
            $rooms->is_aktif = 1; // Set default aktif
            $rooms->save();

            return response('User Berhasil dibuat', 201);
        }
        return response('User dengan email ini sudah ada', 422);

        // $rooms = new AdminUser;

        // Cek database
        // dd($req->in_santri);
        // $is_available = $rooms->where('email', '=', $req->in_name)->count();

        // if ($is_available < 1) {
        //     // Insert
        //     $rooms->nama = $req->in_name;
        //     $rooms->email = $req->in_email;
        //     $rooms->password = bcrypt($req->in_password);
        //     $rooms->akses = $req->in_akses;
        //     $rooms->save();

        //     return response('', 201);
        // }

        // return response('', 422);
    }

    public function santri()
    {
        $email = Santri::select('email')->get();

        return view('pages.admin.user.add', ['type_menu' => 'user_list', 'email' => $email]);
        // return $this->hasOne(Santri::class, 'email', 'email');
    }
    public function checkSantriEmail(Request $request)
    {
        $email = $request->input('email');

        $santri = AdminUser::where('email', $email)->first();

        if ($santri) {
            return response()->json([
                'status' => 'success',
                'nama' => $santri->nama
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Santri Tidak ditemukan'
            ]);
        }
    }

    public function show($id)
    {
        $rooms = AdminUser::select(['nama', 'email', 'password', 'akses']);

        $rooms = $rooms->find($id);

        return json_encode($rooms);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req, [
            'in_name' => 'required',
            'in_email' => 'required|email:',
            'in_akses' => 'required'
        ]);

        $rooms = AdminUser::find($id);

        $rooms->nama = $req->in_name;
        $rooms->email = $req->in_email;
        $rooms->akses = $req->in_akses;

        if (isset($req->in_password) && $req->in_password != '') {
            $rooms->password = bcrypt($req->in_password);
        }

        $saved = $rooms->save();

        if (!$saved) {
            return response('Gagal', 400);
        }

        return response('Sukses', 200);
    }

    public function destroy($id)
    {
        $rooms = AdminUser::find($id);

        if ($rooms->delete()) {
            return response('', 200);
        }

        return response('', 400);
    }

    public function active($id, Request $req)
    {
        $db = AdminUser::findOrFail(intval($id));

        $db->is_aktif = $db->is_aktif == '0' ? '1' : '0';
        $saved = $db->save();

        if (!$saved) {
            return response('', 400);
        }

        return response('', 200);
    }
}
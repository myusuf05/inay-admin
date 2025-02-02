<?php

namespace App\Http\Controllers\Pendataan;

use App\Http\Controllers\Controller;
use App\Models\Pendataan\Alumni;
use App\Models\Pendataan\Santri;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {
    $send_data = [
      'type_menu' => 'dashboard',
      'total' => $this->get_total()
    ];

    return view('pages.admin.dashboard', $send_data);
  }

  private function get_total()
  {
    $santri = Santri::all();
    $alumni = Alumni::all();
    $santri_putri = $santri->where('jns_kelamin', '=', 'P')->count();
    $santri_putra = $santri->where('jns_kelamin', '=', 'L')->count();

    return [
      'santri' => $santri->count(),
      'alumni' => $alumni->count(),
      'santri_putri' => $santri_putri,
      'santri_putra' => $santri_putra
    ];
  }

  public function stats_santri()
  {
    $santri = Santri::select(
      DB::raw("count(id_santri) as total"),
      DB::raw("(DATE_FORMAT(tgl_masuk, '%Y')) as year")
    )->groupBy('year');

    $get_data = $santri->get()->toArray();
    $year = [];
    $total = [];
    foreach ($get_data as $gd) {
      array_push($total, $gd['total']);
      array_push($year, $gd['year']);
    }

    $stats = [
      'tahun' => $year,
      'total' => $total
    ];

    return json_encode($stats);
  }
}

<?php

namespace App\Http\Controllers\Pendataan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    public function index()
    {
        return view('pages.admin.pendataan.address', ['type_menu' => 'data_setting']);
    }
}

<?php

namespace App\Http\Controllers\Pendataan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataIndukController extends Controller
{
    public function index()
    {
        return view('pages.admin.pendataan.data-induk', ['type_menu' => 'data_setting']);
    }
}

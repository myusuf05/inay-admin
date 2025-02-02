<?php

namespace App\Models\Pendataan\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
  use HasFactory;

  protected $table = 'provinsi';

  protected $primaryKey = 'id_provinsi';

  protected $fillable = [
    'provinsi'
  ];
}

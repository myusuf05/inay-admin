<?php

namespace App\Models\Pendataan\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
  use HasFactory;

  protected $table = 'pendidikan';

  protected $primaryKey = 'id_pendidikan';

  protected $fillable = [
    'pendidikan',
    'is_aktif'
  ];
}

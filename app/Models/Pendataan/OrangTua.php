<?php

namespace App\Models\Pendataan;

use App\Models\Pendataan\Setting\Gaji;
use App\Models\Pendataan\Setting\Pekerjaan;
use App\Models\Pendataan\Setting\Pendidikan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrangTua extends Model
{
  use HasFactory;

  protected $table = 'orang_tua';

  protected $primaryKey = 'id_ortu';

  protected $fillable = [
    'id_pendidikan',
    'id_pekerjaan',
    'id_gaji',
    'nama',
    'jns_kelamin',
    'is_wali',
    'is_hidup',
    'no_hp',
    'nik',
  ];

  public function pendidikan(): HasOne
  {
    return $this->hasOne(Pendidikan::class);
  }

  public function pekerjaan(): HasOne
  {
    return $this->hasOne(Pekerjaan::class);
  }

  public function gaji(): HasOne
  {
    return $this->hasOne(Gaji::class);
  }
}

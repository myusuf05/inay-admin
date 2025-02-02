<?php

namespace App\Models\Pendataan\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kabupaten extends Model
{
  use HasFactory;

  protected $table = 'kabupaten';

  protected $primaryKey = 'id_kabupaten';

  protected $fillable = [
    'id_provinsi',
    'kabupaten'
  ];

  public function provinsi(): HasOne
  {
    return $this->hasOne(Provinsi::class);
  }
}

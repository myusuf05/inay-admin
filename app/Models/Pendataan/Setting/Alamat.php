<?php

namespace App\Models\Pendataan\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Alamat extends Model
{
  use HasFactory;

  protected $table = 'alamat';

  protected $primaryKey = 'id_alamat';

  protected $fillable = [
    'alamat',
    'id_kecamatan'
  ];

  public function kecamatan(): HasOne
  {
    return $this->hasOne(Kecamatan::class);
  }
}

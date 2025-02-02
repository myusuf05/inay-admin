<?php

namespace App\Models\Pendataan\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kecamatan extends Model
{
  use HasFactory;

  protected $table = 'kecamatan';

  protected $primaryKey = 'id_kecamatan';

  protected $fillable = [
    'id_kabupaten',
    'kecamatan'
  ];

  public function kabupaten(): HasOne
  {
    return $this->hasOne(Kabupaten::class);
  }
}

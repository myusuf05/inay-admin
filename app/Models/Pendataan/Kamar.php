<?php

namespace App\Models\Pendataan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kamar extends Model
{
  use HasFactory;

  protected $table = 'kamar';

  protected $primaryKey = 'id_kamar';

  protected $fillable = [
    'kamar',
    'area'
  ];
}

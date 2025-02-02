<?php

namespace App\Models\Pendataan\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gaji';
  
    protected $primaryKey = 'id_gaji';
  
    protected $fillable = [
      'gaji',
      'is_aktif'
    ];
}

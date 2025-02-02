<?php

namespace App\Models\Pendataan\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;

    protected $table = 'pekerjaan';
  
    protected $primaryKey = 'id_pekerjaan';
  
    protected $fillable = [
      'pekerjaan',
      'is_aktif'
    ];
}

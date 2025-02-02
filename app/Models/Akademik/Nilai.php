<?php

namespace App\Models\Akademik;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $primaryKey = 'id_nilai';

    protected $fillable = [
        'id_pengajar',
        'id_santri',
        'id_mapel',
        'nilai',
    ];
}

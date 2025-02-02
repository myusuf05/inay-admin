<?php

namespace App\Models\Akademik;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajar extends Model
{
    use HasFactory;

    protected $table = 'pengajar';

    protected $primaryKey = 'id_pengajar';

    protected $fillable = [
        'nama',
        'alamat',
        'jns_kelamin',
        'no_hp'
    ];
}

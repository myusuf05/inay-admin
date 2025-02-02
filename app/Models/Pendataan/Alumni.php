<?php

namespace App\Models\Pendataan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni';

    protected $primaryKey = 'id_alumni';

    protected $fillable = [
        'id_ayah',
        'id_alumni',
        'id_ibu',
        'id_alamat',
        'nama',
        'tgl_lahir',
        'jenis_kelamin',
        'no_hp',
        'email',
        'nik',
        'tgl_masuk',
        'tgl_keluar',
    ];
}
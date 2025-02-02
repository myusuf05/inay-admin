<?php

namespace App\Models\Pendataan;

use App\Models\Akademik\Jadwal;
use App\Models\Pendataan\Setting\Alamat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Santri extends Model
{
    use HasFactory;

    protected $table = 'santri';

    protected $primaryKey = 'id_santri';

    protected $fillable = [
        'id_santri',
        'id_ayah',
        'id_ibu',
        'id_alamat',
        'id_kelas',
        'id_kamar',
        'nama',
        'tgl_lahir',
        'jns_kelamin',
        'no_hp',
        'email',
        'password',
        'nik',
        'photo',
        'tgl_masuk',
    ];



    public function user()
    {
        return $this->hasOne(Santri::class, 'email', 'email');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'santri_id');
    }
    // public function kelas(): HasOne
    // {
    //   return $this->hasOne(Kelas::class);
    // }

    // public function kamar(): HasOne 
    // {
    //   return $this->hasOne(Kamar::class);
    // }

    // public function alamat(): HasOne 
    // {
    //   return $this->hasOne(Alamat::class);
    // }

    // public function ortu(): HasMany 
    // {
    //   return $this->hasMany(OrangTua::class);
    // }
}
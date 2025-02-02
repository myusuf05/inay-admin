<?php

namespace App\Models\Pendataan\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusSantri extends Model
{
	use HasFactory;

	protected $table = 'status_santri';

	protected $primaryKey = 'id_status';

	protected $fillable = [
		'status_santri',
		'is_aktif'
	];
}

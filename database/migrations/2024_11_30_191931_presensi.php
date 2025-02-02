<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensi', function (Blueprint $table) {
            $table->bigInteger('id_presensi', true)->autoIncrement();
            $table->bigInteger('id_santri')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('waktu')->nullable();
            $table->enum('status', ['Hadir', 'Sakit', 'Izin', 'Pulang', 'Tanpa Keterangan'])->default('Hadir');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presensi');
    }
};

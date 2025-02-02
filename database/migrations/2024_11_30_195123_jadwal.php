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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->bigInteger('id_jadwal', true)->autoIncrement();
            $table->bigInteger('id_kelas')->nullable();
            $table->bigInteger('id_mapel')->nullable();
            $table->bigInteger('id_pengajar')->nullable();
            $table->string('hari')->nullable();
            $table->string('mulai')->nullable();
            $table->string('selesai')->nullable();
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
        Schema::dropIfExists('jadwal');
    }
};

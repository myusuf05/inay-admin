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
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->bigInteger('id_ortu', true)->autoIncrement();
            $table->bigInteger('id_pekerjaan')->nullable();
            $table->bigInteger('id_gaji')->nullable();
            $table->bigInteger('id_pendidikan')->nullable();
            $table->string('nama')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('nik')->nullable();
            $table->string('alamat')->nullable();
            $table->boolean('is_hidup')->default(true);
            $table->boolean('is_wali')->default(false);
            $table->enum('jenis_kelamin', ['L', 'P'])->default('L');
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
        Schema::dropIfExists('orang_tua');
    }
};

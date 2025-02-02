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
        Schema::create('santri', function (Blueprint $table) {
            $table->bigInteger('id_santri', true);
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id_user')->on('user')->onDelete('cascade');
            $table->bigInteger('id_ayah')->nullable();
            $table->bigInteger('id_ibu')->nullable();
            $table->bigInteger('id_kelas')->nullable();
            $table->bigInteger('id_kamar')->nullable();
            $table->string('nama');
            $table->string('nik')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->string('alamat')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->text('photo')->nullable();
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
        Schema::dropIfExists('santri');
    }
};

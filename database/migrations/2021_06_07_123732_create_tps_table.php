<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('provinsi_id');
            $table->unsignedBigInteger('kota_kab_id');
            $table->unsignedBigInteger('kecamatan_id');
            $table->unsignedBigInteger('kelurahan_id');
            $table->string('tps');
            $table->string('jumlah');
            $table->timestamps();

            $table->foreign('provinsi_id')->references('id')->on('provincies')->cascadeOnDelete();
            $table->foreign('kota_kab_id')->references('id')->on('kota_kabs')->cascadeOnDelete();
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans')->cascadeOnDelete();
            $table->foreign('kelurahan_id')->references('id')->on('kelurahans')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tps');
    }
}

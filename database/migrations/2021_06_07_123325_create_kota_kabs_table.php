<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKotaKabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kota_kabs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('provinsi_id');
            $table->string('nama');
            $table->char('kode_kota_kab', 2);
            $table->timestamps();
            
            $table->foreign('provinsi_id')->references('id')->on('provincies')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kota_kabs');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelurahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelurahans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kecamatan_id');
            $table->string('nama');
            $table->char('kode_kelurahan', 4);
            $table->timestamps();
            
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelurahans');
    }
}

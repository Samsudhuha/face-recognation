<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPenduduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_penduduks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('nik');
            $table->string('kk');
            $table->string('antrean', 3);
            $table->unsignedBigInteger('tps_id');
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->foreign('tps_id')->references('id')->on('tps')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_penduduks');
    }
}

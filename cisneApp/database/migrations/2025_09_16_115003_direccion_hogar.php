<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DireccionHogar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direccion_hogar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ciudad');
            $table->string('localidad')->default("");
            $table->string('calle');
            $table->integer('altura');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direccion_hogar');
    }
}

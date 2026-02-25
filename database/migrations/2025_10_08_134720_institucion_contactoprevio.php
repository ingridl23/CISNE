<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InstitucionContactoprevio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'instituciones_contactoprevio',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre');
                $table->string('email')->unique();
                $table->string('telefono');
            }
        );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    Schema::dropIfExists('instituciones_contactoprevio');
    }
}

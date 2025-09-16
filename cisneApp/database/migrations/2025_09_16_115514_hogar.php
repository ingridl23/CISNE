<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;

class Hogar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'HogarMayor',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre');
                $table->text('descripcion');
                $table->foreignId('redes_id')->constrained('RedHogar')->onDelete('cascade');
                $table->foreignId('direccion_id')->constrained('DireccionHogar')->onDelete('cascade');
                $table->timestamps();
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

        Schema::dropIfExists('HogarMayor');
    }
}

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
            'hogar_mayor',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre');
                $table->text('descripcion');
                $table->unsignedBigInteger('redes_id');
                $table->foreign('redes_id')->references('id')->on('red_hogar')->onDelete('cascade');
             
$table->unsignedBigInteger('direccion_id');
$table->foreign('direccion_id')
      ->references('id')
      ->on('direccion_hogar')
      ->onDelete('cascade');


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
 Schema::table('hogar_mayor', function (Blueprint $table) {
            $table->dropForeign(['redes_id']);
            $table->dropForeign(['direccion_id']);
        });

       
        Schema::dropIfExists('hogar_mayor');
    }
}

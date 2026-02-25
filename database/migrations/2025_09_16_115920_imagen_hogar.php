<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ImagenHogar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'imagen_hogar',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                  $table->foreignId('hogar_id')->constrained('hogar_mayor')->onDelete('cascade');

                $table->string('url')->nullable();
                $table->string('public_id')->nullable();
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
         Schema::table('imagen_hogar', function (Blueprint $table) {
            $table->dropForeign(['hogar_id']);
        });

        Schema::dropIfExists('imagen_hogar');
    }
}

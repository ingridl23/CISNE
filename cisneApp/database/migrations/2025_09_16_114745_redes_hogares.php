<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RedesHogares extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RedHogar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->bigInteger('whatsapp');
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

        Schema::dropIfExists(
            'RedHogar'
        );
    }
}

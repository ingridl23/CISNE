<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProfesionalEnvioCV extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'profesional_evioCV',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre');
                $table->string('email')->unique();
                $table->string('telefono');
                $table->string('cv_path'); //url o nombre del pdf
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
        Schema::dropIfExists('profesional_evioCV');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ImagenesProfesionales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'ImagenProfesional',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->foreignId('profesional_id')->constrained('Profesional')->onDelete('cascade');
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
    public function down() {}
}

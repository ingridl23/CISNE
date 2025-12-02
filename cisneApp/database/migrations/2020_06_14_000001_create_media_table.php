<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    public function up()
    {
        Schema::table('imagenes_profesional', function (Blueprint $table) {
            $table->string('public_id')->nullable()->after('url');
        });
    }

    public function down()
    {
        Schema::table('imagenes_profesional', function (Blueprint $table) {
            $table->dropColumn('public_id');
        });
    }
}

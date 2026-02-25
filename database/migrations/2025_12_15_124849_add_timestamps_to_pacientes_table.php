<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToPacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
{
    Schema::table('pacientes', function (Blueprint $table) {
        if (!Schema::hasColumn('pacientes', 'created_at')) {
            $table->timestamp('created_at')->nullable();
        }

        if (!Schema::hasColumn('pacientes', 'updated_at')) {
            $table->timestamp('updated_at')->nullable();
        }
    });
}

public function down()
{
    Schema::table('pacientes', function (Blueprint $table) {
        if (Schema::hasColumn('pacientes', 'created_at')) {
            $table->dropColumn('created_at');
        }

        if (Schema::hasColumn('pacientes', 'updated_at')) {
            $table->dropColumn('updated_at');
        }
    });
}
}

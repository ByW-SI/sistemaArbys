<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContratosToOficinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oficinas', function (Blueprint $table) {
            //
            $table->string('archivo_agua');
            $table->string('archivo_luz');
            $table->string('archivo_telefono');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oficinas', function (Blueprint $table) {
            //
             $table->dropColumn('archivo_agua');
            $table->dropColumn('archivo_luz');
            $table->dropColumn('archivo_telefono');
        });
    }
}

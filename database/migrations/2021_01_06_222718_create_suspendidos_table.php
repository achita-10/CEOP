<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuspendidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suspendidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ID_Miembro')->unsigned();
            $table->foreign('ID_Miembro')->references('id')->on('miembros');
            $table->string('Motivo',100)->nullable();
            $table->date('FechaInactivo')->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suspendidos');
    }
}

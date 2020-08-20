<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ID_Miembro')->unsigned();
            $table->foreign('ID_Miembro')->references('id')->on('Miembros');
            $table->string('Correo',70)->nullable();
            $table->string('Telefono',20)->nullable();
            $table->string('Direccion',70)->nullable();
            $table->string('Ocupacion',70)->nullable();
            $table->string('Padre',80)->nullable();
            $table->string('Madre',80)->nullable();
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
        Schema::dropIfExists('contactos');
    }
}

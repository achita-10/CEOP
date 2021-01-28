<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIglesiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iglesias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ID_Miembro')->unsigned();
            $table->foreign('ID_Miembro')->references('id')->on('Miembros');
            
            $table->date('FechaConversion')->nullable();
            $table->string('Bautizado',10)->nullable();
            $table->date('FechaBautizo')->nullable();
            $table->string('Iglesia',60)->nullable();
            
            $table->date('FechaDeceso')->nullable();
            $table->integer('Deceso')->nullable();
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
        Schema::dropIfExists('iglesias');
    }
}

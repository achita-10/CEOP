<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiembrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miembros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Nombre',60);
            $table->string('Apellido_P',60);
            $table->string('Apellido_M',60);
            $table->integer('Genero');
            $table->string('EstadoCivil',10);
            $table->date('FechaNac');
            $table->string('Imagen',50)->nullable();
            $table->timestamps();
        });
         //Permite insertar roles
        //  DB::table('miembros')->insert(array('id'=>'1','Nombre'=>'Administrador'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('miembros');
    }
}

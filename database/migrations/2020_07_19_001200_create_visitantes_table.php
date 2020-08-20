<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Nombre',60);
            $table->string('Apellido_P',60);
            $table->string('Apellido_M',60);
            $table->string('Correo',80)->nullable();
            $table->string('Telefono',15)->nullable();
            $table->string('Congregacion',70)->nullable();
            $table->string('RedSocial',60)->nullable();
            $table->string('Imagen',100)->nullable();
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
        Schema::dropIfExists('visitantes');
    }
}

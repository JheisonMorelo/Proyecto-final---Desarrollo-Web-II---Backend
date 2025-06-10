<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cita', function (Blueprint $table) {
            $table->string('codigo')->primary();
            $table->string('idCliente');
            $table->string('idRecepcionista');
            $table->dateTime('fechaCita');
            $table->string('estado');
            $table->double('costoTotal');

            $table->foreign('idCliente')->references('cedula')->on('cliente');
            $table->foreign('idRecepcionista')->references('cedula')->on('recepcionista');
        });

        Schema::create('servicio', function (Blueprint $table) {
            $table->string('codigo')->primary();
            $table->string('nombre');
            $table->longText('descripcion');
            $table->double('precio');
        });

        Schema::create('contieneCita', function (Blueprint $table) {
            $table->string('codigoCita');
            $table->string('codigoServicio');


            $table->foreign('codigoCita')->references('codigo')->on('cita');
            $table->foreign('codigoServicio')->references('codigo')->on('servicio');

            $table->primary(['codigoCita', 'codigoServicio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cita');
        Schema::dropIfExists('servicio');
        Schema::dropIfExists('contieneCita');
    }
};

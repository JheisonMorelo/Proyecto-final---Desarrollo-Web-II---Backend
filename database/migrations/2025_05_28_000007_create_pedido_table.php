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
        Schema::create('pedido', function (Blueprint $table) {
            $table->string('codigo')->primary();
            $table->string('idCliente');
            $table->string('idAsistenteVentas');
            $table->string('direccion');
            $table->dateTime('fechaRegistro');
            $table->string('estado');
            $table->double('costoTotal');

            $table->foreign('idCliente')->references('cedula')->on('cliente');
            $table->foreign('idAsistenteVentas')->references('cedula')->on('asistenteVentas');
        });


        Schema::create('producto', function (Blueprint $table) {
            $table->string('codigo')->primary();
            $table->string('nombre');
            $table->longText('descripcion');
            $table->double('precio');
            $table->integer('stock');
            $table->string('urlImage')->nullable();
        });

        Schema::create('contienePedido', function (Blueprint $table) {
            $table->string('codigoPedido');
            $table->string('codigoProducto');
            $table->integer('numProductos');

            $table->foreign('codigoPedido')->references('codigo')->on('pedido');
            $table->foreign('codigoProducto')->references('codigo')->on('producto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido');
        Schema::dropIfExists('producto');
        Schema::dropIfExists('contienePedido');
    }
};

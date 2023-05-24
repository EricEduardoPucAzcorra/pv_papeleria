<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->float('total');
            $table->integer('items');
            $table->enum('estatus', ['PENDIENTE', 'COMPLETADO', 'CANCELADO'])->default('PENDIENTE');
            $table->float('pago');
            $table->float('cambio')->nullable();

            //Llaves foraneas con deudores
            $table->unsignedBigInteger('deudor_id')->nullable();
            $table->foreign('deudor_id')->references('id')->on('deudors')->onDelete('set null');

            //Llaves foraneas con user
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            
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
        Schema::dropIfExists('ventas');
    }
};

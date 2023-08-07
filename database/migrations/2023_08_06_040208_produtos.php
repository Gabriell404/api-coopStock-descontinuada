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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->text('produto');
            $table->bigInteger('numero_de_serie');
            $table->text('detalhes');
            $table->float('valor');
            $table->bigInteger('numero_de_patrimonio');
            $table->enum('estado', ['alocado', 'disponivel', 'indisponivel']);
            $table->unsignedBigInteger('fornecedor_id');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
            $table->foreign('categoria_id')->references('id')->on('categorias');
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
        //
    }
};

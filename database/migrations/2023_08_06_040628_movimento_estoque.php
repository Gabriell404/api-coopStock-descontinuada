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
        
 Schema::create('movimento_estoques', function (Blueprint $table) {
    $table->id();
    $table->text('descricao');
    $table->unsignedBigInteger('produto_id');
    $table->unsignedBigInteger('origem_id');
    $table->unsignedBigInteger('destino_id');
    $table->foreign('produto_id')->references('id')->on('produtos');
    $table->foreign('origem_id')->references('id')->on('setores');
    $table->foreign('destino_id')->references('id')->on('setores');
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

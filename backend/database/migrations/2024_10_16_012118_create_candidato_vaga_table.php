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
        Schema::create('candidato_vaga', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('id_candidato');
            $table->foreign('id_candidato')->references('id')->on('candidato')->onDelete('cascade')->onUpdate('cascade');
            
            $table->unsignedBigInteger('id_vaga');
            $table->foreign('id_vaga')->references('id')->on('vaga')->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('candidato_vaga');
    }
};

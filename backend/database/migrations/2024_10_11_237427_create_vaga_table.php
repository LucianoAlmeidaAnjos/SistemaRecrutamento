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
        Schema::create('vaga', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->text('habilidades');
            $table->text('requisitos')->nullable();
            $table->integer('experiencia');
            $table->string('localizacao');
            $table->date('data_abertura')->nullable();
            $table->date('data_fechamento')->nullable();
            $table->double('salario_min', 10, 2);
            $table->double('salario_max', 10, 2)->nullable();
            
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            
            $table->unsignedBigInteger('id_tipo_contrato');
            $table->foreign('id_tipo_contrato')->references('id')->on('tipo_contrato')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaga');
    }
};

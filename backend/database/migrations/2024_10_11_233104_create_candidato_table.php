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
        Schema::create('candidato', function (Blueprint $table) {
            $table->id();
            $table->text('experiencia');
            $table->text('habilidades');
            $table->integer('tempo');
            $table->double('salario_min', 10, 2)->nullable();
            $table->double('salario_max', 10, 2)->nullable();
            $table->string('telefone');

            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidato');
    }
};

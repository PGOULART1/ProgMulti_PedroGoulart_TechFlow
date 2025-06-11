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
        Schema::create('chamados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID do usuário que criou o chamado
            /*$table->unsignedBigInteger('tecnico_id')->nullable(); // ID do técnico responsável pelo chamado*/
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Chave estrangeira para o usuário que criou o chamado
            $table->string('titulo');
            $table->text('descricao');
            $table->enum('prioridade', ['baixa', 'media', 'alta'])->default('media');
            $table->string('status')->default('aberto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chamados');
    }
};

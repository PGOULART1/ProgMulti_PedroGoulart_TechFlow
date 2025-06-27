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
        Schema::create('anexos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chamado_id')->constrained()->onDelete('cascade');
            $table->string('nome_arquivo_hash'); // O nome que o Laravel dá ao salvar (hash)
            $table->string('nome_original');    // O nome que o usuário deu
            $table->string('tipo_mime');        // Ex: image/png, application/pdf
            $table->string('caminho');          // Ex: 'anexos/2025/06/nomehash.png' - pode ser o 'nome_arquivo_hash' com subpastas
            $table->integer('tamanho');         // Tamanho do arquivo em bytes
            $table->timestamps();
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anexos');
    }
};

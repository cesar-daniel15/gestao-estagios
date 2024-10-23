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
        Schema::create('companies', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->string('name'); // Nome da empresa
            $table->string('email')->unique(); // Email único
            $table->string('phone'); // Telefone
            $table->string('picture')->nullable(); // Imagem (pode ser nulo)
            $table->string('industry'); // Indústria
            $table->text('brief_description'); // Breve descrição
            $table->string('address'); // Endereço
            $table->date('foundation_date'); // Data de fundação
            $table->string('token')->unique(); // Token único
            $table->boolean('account_is_verify')->default(false); // Conta verificada
            $table->timestamp('last_login')->nullable(); // Último login (pode ser nulo)
            $table->timestamps(); // Gera created_at e updated_at automaticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};

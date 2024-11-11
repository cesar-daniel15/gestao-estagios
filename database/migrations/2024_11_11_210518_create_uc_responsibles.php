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
        Schema::create('uc_responsibles', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->unsignedBigInteger('uc_id'); // Chave estrangeira para 'units_curriculars'
            $table->string('name'); // Nome do responsável
            $table->string('email')->unique(); // Email único
            $table->string('password'); // Senha
            $table->string('phone'); // Telefone
            $table->string('picture')->nullable(); // Foto do responsável (pode ser nula)
            $table->string('token')->unique(); // Token único
            $table->boolean('account_is_verify')->default(false); // Verificação da conta
            $table->timestamp('last_login')->nullable(); // Último login (pode ser nulo)
            $table->timestamps(); // Gera created_at e updated_at automaticamente

            // Define a chave estrangeira para a tabela units_curriculars
            $table->foreign('uc_id')->references('id')->on('units_curriculars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uc_responsibles');
    }
};

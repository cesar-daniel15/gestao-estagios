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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nome
            $table->enum('profile', ['Institution', 'Company', 'Responsible', 'Student', 'Admin']); // Tipos de utilizadores
            $table->string('email')->unique(); // Email
            $table->text('password'); // Password

            // Chaves estrangeiras 
            $table->unsignedBigInteger('id_institution')->nullable();
            $table->unsignedBigInteger('id_company')->nullable();
            $table->unsignedBigInteger('id_responsible')->nullable();
            $table->unsignedBigInteger('id_student')->nullable();

            $table->string('token')->nullable()->unique(); // Token de 5 números (deve ser unico)
            $table->boolean('account_is_verified')->default(false); // Conta verificada
            $table->timestamp('last_login')->nullable(); // Ultimo login (Pode ser NULL)
            $table->timestamps(); // Gera created_at e updated_at

            //Ligacao das FK'S
            $table->foreign('id_institution')->references('id')->on('institutions')->onDelete('set null');
            $table->foreign('id_company')->references('id')->on('companies')->onDelete('set null');
            $table->foreign('id_responsible')->references('id')->on('uc_responsibles')->onDelete('set null');
            $table->foreign('id_student')->references('id')->on('students')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

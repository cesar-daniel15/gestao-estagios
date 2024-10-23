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
        Schema::create('courses', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->foreignId('institution_id')->constrained(); // Chave estrangeira para 'institutions'
            $table->string('name'); // Nome do curso
            $table->string('acronym'); // Acrônimo do curso
            $table->timestamps(); // Gera created_at e updated_at automaticamente
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};

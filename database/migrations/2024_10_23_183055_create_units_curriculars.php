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
        Schema::create('units_curriculars', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->foreignId('course_id')->constrained(); // Chave estrangeira para 'courses'
            $table->string('name'); // Nome da unidade curricular
            $table->string('acronym'); // Acrônimo da unidade curricular
            $table->integer('ects'); // Número de ECTS
            $table->timestamps(); // Gera created_at e updated_at automaticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units_curriculars');
    }
};

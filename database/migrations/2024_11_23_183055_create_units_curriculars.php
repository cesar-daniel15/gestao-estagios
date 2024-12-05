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
            $table->unsignedBigInteger('course_id'); // FK para 'courses'
            $table->string('name'); // Nome da unidade curricular
            $table->string('acronym'); // Acrônimo da unidade curricular
            $table->integer('ects'); // Número de ECTS
            $table->timestamps(); // Gera created_at e updated_at automaticamente

            // Define a FK para a tabela courses
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
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

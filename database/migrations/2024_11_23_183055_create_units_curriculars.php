php artisan make:migration create_nome_da_tabela<?php

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
<<<<<<<< HEAD:database/migrations/2024_11_28_103046_create_units_curriculars.php
            $table->string('id')->primary();
            $table->unsignedBigInteger('course_id'); // Chave estrangeira para 'courses'
========
            $table->id(); // Chave primária
            $table->unsignedBigInteger('course_id'); // FK para 'courses'
>>>>>>>> main:database/migrations/2024_11_23_183055_create_units_curriculars.php
            $table->string('name'); // Nome da unidade curricular
            $table->string('acronym'); // Acrônimo da unidade curricular
            $table->integer('ects'); // Número de ECTS
            $table->timestamps(); // Gera created_at e updated_at automaticamente

<<<<<<<< HEAD:database/migrations/2024_11_28_103046_create_units_curriculars.php
            // Define a chave estrangeira para a tabela courses
========
            // Define a FK para a tabela courses
>>>>>>>> main:database/migrations/2024_11_23_183055_create_units_curriculars.php
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
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
            $table->id();
            $table->unsignedBigInteger('course_id'); // FK para Courses
            $table->string('name'); // Nome 
            $table->string('acronym'); // Acronimo
            $table->integer('ects'); // ECTS
            $table->timestamps();

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

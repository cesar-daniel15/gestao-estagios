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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('phone'); // Contacto  do aluno
            $table->string('picture')->nullable(); // Foto 
            $table->unsignedBigInteger('assigned_internship_id')->nullable(); // FK para o estagio
            $table->timestamps();

            // Fk's
            $table->foreign('assigned_internship_id')->references('id')->on('internship_offers'); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

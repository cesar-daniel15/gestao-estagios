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
        Schema::create('internship_plans', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->integer('max_hours'); // Número máximo de horas
            $table->date('start_date'); // Data de início
            $table->date('end_date'); // Data de término
            $table->text('objectives'); // Objetivos do estágio
            $table->text('planned_activities'); // Atividades planejadas
            $table->boolean('approved_by_uc')->default(false); // Aprovado pela UC
            $table->string('status'); // Status do plano de estágio
            $table->timestamps(); // Gera created_at e updated_at automaticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_plans');
    }
};

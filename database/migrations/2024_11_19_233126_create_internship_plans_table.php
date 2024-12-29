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
            $table->id();
            $table->unsignedBigInteger('internship_offer_id'); // FK para Internship Offers
            $table->integer('total_hours'); // Total de horas
            $table->date('start_date'); // Data de início
            $table->date('end_date'); // Data do fim
            $table->text('objectives'); // Objetivos
            $table->text('planned_activities'); // Atividades 
            $table->boolean('approved_by_uc')->default(false); // Aprovado pela UC
            $table->enum('status', ['pending', 'approved', 'rejected']); // Status
            $table->timestamps();

            // Ligação da FK
            $table->foreign('internship_offer_id')->references('id')->on('internship_offers')->onDelete('cascade'); 
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

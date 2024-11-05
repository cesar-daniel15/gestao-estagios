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
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id(); // PK
            $table->unsignedBigInteger('internship_offer_id'); // FK para oferta de estágio
            $table->date('date'); // Data de presença
            $table->time('morning_start_time')->nullable(); // Horário de início da manhã
            $table->time('morning_end_time')->nullable(); // Horário de término da manhã
            $table->time('afternoon_start_time')->nullable(); // Horário de início da tarde
            $table->time('afternoon_end_time')->nullable(); // Horário de término da tarde
            $table->integer('approval_hours')->nullable(); // Horas aprovadas
            $table->text('summary')->nullable(); // Resumo do dia
            $table->timestamps();

            // Definindo a FK
            $table->foreign('internship_offer_id')->references('id')->on('internship_offers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};

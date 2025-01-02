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
            $table->id();
            $table->unsignedBigInteger('internship_offer_id'); // FK para Internship_Offers
            $table->date('date'); // Data de registro
            $table->time('morning_start_time'); // Início da manhã
            $table->time('morning_end_time'); // Fim da manhã
            $table->time('afternoon_start_time'); // Início da tarde
            $table->time('afternoon_end_time'); // Fim da tarde
            $table->string('approval_hours'); // Horas para serem aprovadas
            $table->text('summary'); // Resumo
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending'); // Status de aprovação por parte da empresa
            $table->timestamps();

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

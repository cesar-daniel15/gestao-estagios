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
        Schema::create('final_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_offer_id')->constrained('internship_offers')->onDelete('cascade'); 
            $table->integer('total_hours'); // Total de horas
            $table->integer('total_days'); // Total de dias
            $table->string('final_report_file_path'); // Caminho para o ficheiro do relatorio final
            $table->text('company_evaluation')->nullable(); // Avaliação da empresa
            $table->text('final_evaluation')->nullable(); // Avaliação final
            $table->enum('status', [ 'submitted', 'evaluated', 'rejected']); // Status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_reports');
    }
};

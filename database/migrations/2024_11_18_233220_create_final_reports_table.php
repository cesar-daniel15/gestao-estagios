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
            $table->integer('total_hours'); // Total de horas
            $table->integer('total_days'); // Total de dias
            $table->text('final_report_content'); // Conteúdo do relatório final
            $table->text('company_evaluation'); // Avaliação da empresa
            $table->text('final_evaluation'); // Avaliação final
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected']); // Status
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

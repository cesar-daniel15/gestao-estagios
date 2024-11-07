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
        Schema::create('internship_offers', function (Blueprint $table) {
            $table->id(); // ID (Primary Key)
            
            // Chave estrangeira para 'companies'
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            
            // Chave estrangeira para 'institutions'
            $table->unsignedBigInteger('institution_id');
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('cascade');
            
            // Chave estrangeira para 'courses'
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            
            $table->string('title'); // Título do estágio
            $table->text('description'); // Descrição do estágio
            $table->date('deadline'); // Data limite para candidatura
            
            // Chave estrangeira opcional para 'internship_plans'
           // $table->unsignedBigInteger('plan_id')->nullable();
            //$table->foreign('plan_id')->references('id')->on('internship_plans')->onDelete('set null');
            
            // Chave estrangeira opcional para 'final_reports'
            //$table->unsignedBigInteger('final_report')->nullable();
            //$table->foreign('final_report')->references('id')->on('final_reports')->onDelete('set null');
            
            $table->string('status')->default('open'); // Status do estágio (valor padrão "open")
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_offers');
    }
};

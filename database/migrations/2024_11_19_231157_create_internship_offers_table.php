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
            $table->id();
            $table->unsignedBigInteger('company_id'); // FK para Companies
            $table->unsignedBigInteger('institution_id'); // FK para Institutions
            $table->unsignedBigInteger('course_id'); // FK para Courses
            $table->string('title'); // Titulo
            $table->text('description'); // Descricao
            $table->date('deadline'); // Prazo
            $table->unsignedBigInteger('final_report_id')->nullable(); // FK para Final_Reports
            $table->enum('status', ['open', 'closed', 'archived'])->default('open'); // Status
            $table->timestamps();

            //Ligacao das FK'S
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('final_report_id')->references('id')->on('final_reports')->onDelete('set null');
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

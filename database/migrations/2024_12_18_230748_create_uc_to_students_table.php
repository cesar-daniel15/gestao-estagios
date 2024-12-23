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
        Schema::create('uc_to_students', function (Blueprint $table) {
            $table->unsignedBigInteger('uc_id'); // FK para Units_Curriculars
            $table->unsignedBigInteger('student_num'); // FK para Students
            $table->string('lective_year'); // Ano letivo
            //$table->timestamps();

            $table->primary(['uc_id', 'student_num']);

            $table->foreign('uc_id')->references('id')->on('units_curriculars')->onDelete('cascade');
            $table->foreign('student_num')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uc_to_students');
    }
};

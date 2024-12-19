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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uc_responsible_id'); // FK para Uc_Responsibles
            $table->unsignedBigInteger('student_num'); // FK para Students
            $table->string('title'); // Título da notificação
            $table->text('content'); // Conteúdo
            $table->boolean('status_visualization')->default(false); // Status de visualizacao
            $table->timestamps();

            $table->foreign('uc_responsible_id')->references('id')->on('uc_responsibles')->onDelete('cascade');
            $table->foreign('student_num')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

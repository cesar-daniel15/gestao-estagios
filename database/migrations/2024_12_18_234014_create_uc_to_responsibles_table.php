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
        Schema::create('uc_to_responsibles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uc_responsible_id'); // FK para Uc_Responsibles
            $table->unsignedBigInteger('uc_id'); // FK para a tabela de Unidades Curriculares 
            //$table->timestamps();

            // Chaves estrangeiras
            $table->foreign('uc_responsible_id')->references('id')->on('uc_responsibles')->onDelete('cascade');
            $table->foreign('uc_id')->references('id')->on('units_curriculars')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uc_to_responsibles');
    }
};

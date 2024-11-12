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
            // Chaves primárias compostas
            $table->unsignedBigInteger('id_uc'); // Chave estrangeira para 'units_curriculars'
            $table->unsignedBigInteger('id_responsibles'); // Chave estrangeira para 'responsibles'
            $table->year('lective_year'); // Ano letivo

            // Definir as chaves primárias compostas
            $table->primary(['id_uc', 'id_responsibles']); 

            // Definir as chaves estrangeiras
            $table->foreign('id_uc')->references('id')->on('units_curriculars')->onDelete('cascade');
            $table->foreign('id_responsibles')->references('id')->on('responsibles')->onDelete('cascade');

            $table->timestamps(); // Gera created_at e updated_at automaticamente
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

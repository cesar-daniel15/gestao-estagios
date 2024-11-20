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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('phone'); // Contacto
            $table->string('logo')->nullable(); // Logo 
            $table->string('industry'); // Industria
            $table->text('brief_description')->nullable(); 
            $table->string('address'); // Morada
            $table->date('foundation_date'); // Data de fundacao
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};

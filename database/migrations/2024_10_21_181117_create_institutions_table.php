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
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('acronym'); // Acronimo
            $table->string('phone'); // Telefone
            $table->string('address'); // Morada
            $table->string('logo')->nullable(); // Logo (Pode ser NULL)
            $table->string('website')->nullable(); // Website (Pode ser NULL)
            $table->timestamps(); // Gera created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};

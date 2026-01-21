<?php

declare(strict_types=1);

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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tuteur_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('reference')->unique()->nullable();
            $table->string('prenom');
            $table->string('nom');
            $table->string('contact');
            $table->string('sexe');
            $table->date('naissance');
            $table->timestamps();
            $table->index(['nom', 'prenom']);
            $table->index('reference');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

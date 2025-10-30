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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique()->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('classe_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('type', ['Inscription', 'Scolarité']);
            $table->enum('mode', ['Virement', 'Chèque', 'Espèces', 'Orange Money']);
            $table->string('adresse')->nullable();
            $table->string('motif');
            $table->integer('montant');
            $table->integer('remise')->nullable();
            $table->string('remise_motif')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

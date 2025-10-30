<?php

declare(strict_types=1);

use App\Enum\DevoirEnum;
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
        Schema::create('devoirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('classe_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('matiere_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('periode_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->longText('description');
            $table->string('reference')->unique()->nullable();
            $table->string('type');
            $table->date('delai');
            $table->enum('etat', array_map(fn($etat) => $etat->value, DevoirEnum::cases()))->default('En attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devoirs');
    }
};

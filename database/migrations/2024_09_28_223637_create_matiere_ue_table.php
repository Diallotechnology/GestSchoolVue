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
        Schema::create('matiere_ue', function (Blueprint $table) {
            $table->foreignId('ue_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('matiere_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('coefficient')->nullable();
            $table->primary(['ue_id', 'matiere_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ue_matiere');
    }
};

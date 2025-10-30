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
        Schema::create('classe_matiere', function (Blueprint $table) {
            $table->foreignId('matiere_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('classe_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->primary(['matiere_id', 'classe_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classe_matiere');
    }
};

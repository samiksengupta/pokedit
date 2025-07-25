<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_matchups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attacking_type_id')->constrained('types')->onDelete('cascade');
            $table->foreignId('defending_type_id')->constrained('types')->onDelete('cascade');
            $table->decimal('effectiveness', 3, 1); // e.g. 0.0, 0.5, 1.0, 2.0
            $table->foreignId('version_id')->nullable()->constrained('versions');
            $table->timestamps();
        
            $table->unique(['attacking_type_id', 'defending_type_id']); // prevent duplicates
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_matchups');
    }
};

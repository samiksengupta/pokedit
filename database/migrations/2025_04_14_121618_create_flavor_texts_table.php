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
        Schema::create('flavor_texts', function (Blueprint $table) {
            $table->id();
            $table->text('flavor_text');
            $table->string('textable_type');
            $table->unsignedBigInteger('textable_id');
            $table->foreignId('language_id')->constrained('languages');
            $table->foreignId('version_id')->constrained('versions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flavor_texts');
    }
};

<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_test_questions_and_options_tables.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('test_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained()->cascadeOnDelete();
            $table->string('question');
            $table->unsignedInteger('points')->default(1);
            $table->timestamps();
        });

        Schema::create('test_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('test_questions')->cascadeOnDelete();
            $table->string('text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('test_options');
        Schema::dropIfExists('test_questions');
    }
};

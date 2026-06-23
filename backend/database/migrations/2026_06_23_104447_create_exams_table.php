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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

        $table->foreignId('org_id')
            ->constrained('organizations')
            ->cascadeOnDelete();

        $table->foreignId('subject_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->foreignId('gov_post_id')
            ->nullable()
            ->constrained('government_posts')
            ->nullOnDelete();

        $table->string('title');

        $table->enum('exam_type', [
            'mcq',
            'written',
            'mixed'
        ]);

        $table->boolean('is_paid')->default(false);

        $table->decimal('price', 8, 2)
            ->default(0);

        $table->integer('duration_minutes')
            ->default(60);

        $table->boolean('is_active')
            ->default(true);

        $table->timestamps();
        $table->softDeletes(); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};

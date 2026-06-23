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
        Schema::create('online_classes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('org_id')
                ->constrained('organizations')
                ->cascadeOnDelete();

            $table->foreignId('teacher_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('subject_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->enum('class_type', ['live', 'recorded']);

            $table->string('stream_url')->nullable();   // Zoom/Meet link

            $table->string('record_url')->nullable();   // recorded video

            $table->timestamp('scheduled_at')->nullable();

            $table->integer('duration_minutes')->default(60);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes(); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_classes');
    }
};

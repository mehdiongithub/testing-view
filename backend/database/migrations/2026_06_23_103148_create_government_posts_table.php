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
        Schema::create('government_posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('org_id')
                ->nullable()
                ->constrained('organizations')
                ->nullOnDelete();

            $table->foreignId('country_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->string('department');

            $table->enum('exam_type', [
                'fpsc',
                'ppsc',
                'spsc',
                'kppsc',
                'bpsc',
                'nts',
                'ots',
                'custom'
            ]);

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
        Schema::dropIfExists('government_posts');
    }
};

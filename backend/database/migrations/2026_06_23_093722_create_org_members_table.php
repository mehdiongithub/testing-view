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
        Schema::create('org_members', function (Blueprint $table) {
            $table->id();

        $table->foreignId('org_id')
            ->constrained('organizations')
            ->cascadeOnDelete();

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->enum('role', ['org_admin', 'org_teacher', 'org_student']);

        $table->boolean('is_active')->default(true);

        $table->unique(['org_id', 'user_id']);

        $table->timestamps();
        $table->softDeletes(); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('org_members');
    }
};

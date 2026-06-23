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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('org_id')
                ->constrained('organizations')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete(); // who generated report

            $table->enum('report_type', [
                'exam_performance',
                'student_progress',
                'org_summary',
                'payment_summary',
                'class_attendance'
            ]);

            $table->json('filters')->nullable();        // date range, subject, etc.

            $table->json('data_snapshot')->nullable();  // cached result

            $table->timestamp('generated_at')->useCurrent();

            $table->timestamps();
            $table->softDeletes(); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};

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
        // 1. Project Surveys (Main Table)
        Schema::create('project_surveys', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique(); // Public ID
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('status')->default('DRAFT'); // DRAFT, SURVEY_PLANNED, etc.
            $table->boolean('is_skipped')->default(false);
            $table->text('skip_reason')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->decimal('total_score', 5, 2)->nullable(); // 0.00 to 100.00
            $table->boolean('is_feasible')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->index('status');
            $table->index('project_id');
        });

        // 2. Project Survey Teams (Surveyors)
        Schema::create('project_survey_teams', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->foreignId('survey_id')->constrained('project_surveys')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('department'); // PROJECT, WORKSHOP, HSE
            $table->timestamps();

            $table->unique(['survey_id', 'department']); // One surveyor per dept per survey
        });

        // 3. Project Survey Scores (Results)
        Schema::create('project_survey_scores', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->foreignId('survey_id')->constrained('project_surveys')->onDelete('cascade');
            $table->string('department'); // PROJECT, WORKSHOP, HSE
            $table->decimal('score', 5, 2);
            $table->decimal('weight', 5, 2); // 30, 40, etc.
            $table->decimal('weighted_score', 5, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 4. Project Survey Documents (Evidence)
        Schema::create('project_survey_documents', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->foreignId('survey_id')->constrained('project_surveys')->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type')->default('Berita Acara');
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamps();
        });

        // 5. Project Survey Approvals (Gatekeepers)
        Schema::create('project_survey_approvals', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->unique();
            $table->foreignId('survey_id')->constrained('project_surveys')->onDelete('cascade');
            $table->foreignId('approver_id')->nullable()->constrained('users'); // Nullable if waiting assignment
            $table->string('step'); // MANAGER_OPS, MANAGER_PROJECT
            $table->string('status')->default('PENDING'); // PENDING, APPROVED, REJECTED, REVISION
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 6. Audit Logs (History)
        // Check if table exists first to avoid conflict if system-wide log exists
        if (!Schema::hasTable('audit_logs')) {
            Schema::create('audit_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users');
                $table->string('auditable_type');
                $table->unsignedBigInteger('auditable_id');
                $table->string('action'); // CREATE, UPDATE, DELETE, APPROVE
                $table->json('old_values')->nullable();
                $table->json('new_values')->nullable();
                $table->string('ip_address')->nullable();
                $table->string('user_agent')->nullable();
                $table->timestamps();

                $table->index(['auditable_type', 'auditable_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_surveys_tables');
    }
};

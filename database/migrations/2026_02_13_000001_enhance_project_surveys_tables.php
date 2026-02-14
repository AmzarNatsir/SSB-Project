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
        // Add new columns to existing surveys table
        Schema::table('project_surveys', function (Blueprint $table) {
            if (!Schema::hasColumn('project_surveys', 'created_by')) {
                $table->foreignId('created_by')->nullable()->after('project_id')->constrained('users')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('project_surveys', 'metadata')) {
                $table->json('metadata')->nullable()->after('is_feasible');
            }
            
            if (!Schema::hasColumn('project_surveys', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('metadata');
            }
            
            // Add indexes for performance
            $table->index(['status', 'created_at'], 'idx_status_created');
            $table->index(['project_id', 'status'], 'idx_project_status');
            $table->index('is_feasible', 'idx_is_feasible');
        });
        
        // Create survey_score_criteria table for detailed scoring
        if (!Schema::hasTable('survey_score_criteria')) {
            Schema::create('survey_score_criteria', function (Blueprint $table) {
                $table->id();
                $table->foreignId('survey_score_id')->constrained('project_survey_scores')->onDelete('cascade');
                $table->string('criterion_name');
                $table->decimal('score', 5, 2);
                $table->decimal('max_score', 5, 2);
                $table->text('justification')->nullable();
                $table->timestamps();
                
                $table->index(['survey_score_id', 'criterion_name'], 'idx_score_criterion');
            });
        }
        
        // Create survey_history for audit trail
        if (!Schema::hasTable('survey_history')) {
            Schema::create('survey_history', function (Blueprint $table) {
                $table->id();
                $table->foreignId('survey_id')->constrained('project_surveys')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
                $table->string('event_type', 50);
                $table->json('old_values')->nullable();
                $table->json('new_values')->nullable();
                $table->ipAddress('ip_address')->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();
                
                $table->index(['survey_id', 'created_at'], 'idx_survey_created');
                $table->index('event_type', 'idx_event_type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_history');
        Schema::dropIfExists('survey_score_criteria');
        
        Schema::table('project_surveys', function (Blueprint $table) {
            $table->dropIndex('idx_status_created');
            $table->dropIndex('idx_project_status');
            $table->dropIndex('idx_is_feasible');
            
            if (Schema::hasColumn('project_surveys', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
            
            if (Schema::hasColumn('project_surveys', 'metadata')) {
                $table->dropColumn('metadata');
            }
            
            if (Schema::hasColumn('project_surveys', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
        });
    }
};

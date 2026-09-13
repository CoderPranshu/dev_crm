<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_modules', function (Blueprint $table) {
            $table->id();

            // Project
            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();

            // Module Information
            $table->string('module_name');
            $table->longText('description')->nullable();

            // Department
            $table->foreignId('department_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Lead Developer / Module Owner
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Priority
            $table->enum('priority', [
                'Low',
                'Medium',
                'High',
                'Critical'
            ])->default('Medium');

            // Status
            $table->enum('status', [
                'Pending',
                'Planning',
                'In Progress',
                'Testing',
                'Completed',
                'On Hold',
                'Cancelled'
            ])->default('Pending');

            // Progress
            $table->tinyInteger('progress')
                ->default(0)
                ->comment('0-100');

            // Estimated Hours
            $table->decimal('estimated_hours', 8, 2)
                ->default(0);

            // Actual Hours
            $table->decimal('actual_hours', 8, 2)
                ->default(0);

            // Dates
            $table->date('start_date')->nullable();

            $table->date('deadline')->nullable();

            // Color
            $table->string('color', 20)
                ->default('#4361ee');

            // Tags
            $table->text('tags')->nullable();

            // Display Order
            $table->integer('sort_order')
                ->default(0);

            // Active
            $table->boolean('is_active')
                ->default(true);

            // Created By
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Updated By
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_modules');
    }
};

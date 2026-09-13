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
        Schema::create('backlinks', function (Blueprint $table) {

            $table->id();

            // Category
            $table->foreignId('backlink_category_id')
                ->constrained('backlink_categories')
                ->cascadeOnDelete();

            // Backlink Information
            $table->string('website_url')->unique();

            $table->unsignedSmallInteger('domain_authority')->nullable();

            $table->unsignedSmallInteger('page_authority')->nullable();

            // Credentials (filled after completion)
            $table->string('username')->nullable();

            $table->string('password')->nullable();

            // Status
            $table->enum('status', [
                'available',
                'assigned',
                'completed'
            ])->default('available');

            // Assignment
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('assigned_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('assigned_at')->nullable();

            // Completion
            $table->timestamp('completed_at')->nullable();

            // Uploaded By
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('backlink_category_id');
            $table->index('assigned_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backlinks');
    }
};
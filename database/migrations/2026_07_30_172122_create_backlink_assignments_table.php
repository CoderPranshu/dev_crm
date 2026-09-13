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
        Schema::create('backlink_assignments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | SEO Project
            |--------------------------------------------------------------------------
            */

            $table->foreignId('seo_plan_client_id')
                ->constrained('seo_plan_clients')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Backlink
            |--------------------------------------------------------------------------
            */

            $table->foreignId('backlink_id')
                ->constrained('backlinks')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Assigned SEO Executive
            |--------------------------------------------------------------------------
            */

            $table->foreignId('assigned_to')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Assigned By (SEO Head / Admin)
            |--------------------------------------------------------------------------
            */

            $table->foreignId('assigned_by')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Username & Password
            |--------------------------------------------------------------------------
            */

            $table->string('username')->nullable();

            $table->string('password')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Proof
            |--------------------------------------------------------------------------
            */

            $table->string('attachment')->nullable();

            $table->text('remarks')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'assigned',
                'completed',
            ])->default('assigned');

            /*
            |--------------------------------------------------------------------------
            | Dates
            |--------------------------------------------------------------------------
            */

            $table->timestamp('assigned_at')->nullable();

            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('seo_plan_client_id');
            $table->index('assigned_to');
            $table->index('status');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backlink_assignments');
    }
};
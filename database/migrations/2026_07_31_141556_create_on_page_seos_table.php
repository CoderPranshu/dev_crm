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
        Schema::create('on_page_seos', function (Blueprint $table) {

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
            | Category
            |--------------------------------------------------------------------------
            */

            $table->foreignId('on_page_seo_category_id')
                ->constrained('on_page_seo_categories')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Task
            |--------------------------------------------------------------------------
            */

            $table->foreignId('on_page_seo_task_id')
                ->constrained('on_page_seo_tasks')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'completed'
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | Extra
            |--------------------------------------------------------------------------
            */

            $table->text('remarks')->nullable();

            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('on_page_seos');
    }
};
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
        Schema::create('keywords', function (Blueprint $table) {
            $table->id();

            // Relationship: one SEO Project (SeoPlanClient) has many Keywords
            $table->foreignId('seo_plan_client_id')
                ->constrained('seo_plan_clients')
                ->onDelete('cascade');

            $table->string('keyword');
            $table->string('location')->nullable();
            $table->string('language')->nullable();
            $table->string('search_engine')->default('Google'); // Google, Bing, Yahoo, YouTube, etc.
            $table->enum('device', ['Desktop', 'Mobile', 'Tablet'])->default('Desktop');

            $table->enum('priority', ['Low', 'Medium', 'High', 'Critical'])->default('Medium');
            $table->enum('status', ['Pending', 'Working', 'Ranking', 'Completed', 'Dropped'])->default('Pending');

            $table->unsignedInteger('search_volume')->nullable();
            $table->unsignedTinyInteger('keyword_difficulty')->nullable(); // 0-100
            $table->decimal('cpc', 8, 2)->nullable();

            $table->unsignedInteger('current_rank')->nullable();
            $table->unsignedInteger('target_rank')->nullable();

            $table->string('landing_page')->nullable();

            $table->enum('intent', ['Informational', 'Commercial', 'Transactional', 'Navigational', 'Local'])
                ->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();

            // Helpful indexes for filtering/reporting
            $table->index(['seo_plan_client_id', 'status']);
            $table->index(['seo_plan_client_id', 'priority']);
            $table->index('keyword');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keywords');
    }
};
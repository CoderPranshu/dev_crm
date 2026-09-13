<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_project_keywords', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seo_plan_client_id')
                ->constrained('seo_plan_clients')
                ->onDelete('cascade');
            $table->string('keyword');
            $table->unsignedInteger('search_volume')->nullable();
            $table->unsignedInteger('starting_rank')->nullable();
            $table->timestamps();

            $table->index('seo_plan_client_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_project_keywords');
    }
};
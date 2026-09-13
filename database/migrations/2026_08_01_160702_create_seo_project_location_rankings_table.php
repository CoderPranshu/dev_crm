<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_project_location_rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seo_project_location_id')
                ->constrained('seo_project_locations')
                ->onDelete('cascade');
            $table->unsignedTinyInteger('month_no'); // 0..12
            $table->integer('ranking')->nullable();
            $table->timestamps();

            $table->unique(['seo_project_location_id', 'month_no'], 'splr_location_month_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_project_location_rankings');
    }
};
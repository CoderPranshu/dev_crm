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
        Schema::create('seo_task_distributions', function (Blueprint $table) {

            $table->id();

            // SEO Client
            $table->unsignedBigInteger('seo_plan_client_id');

            // Package Task
            $table->unsignedBigInteger('seo_plan_task_id');

            // Assigned SEO Executive
            $table->unsignedBigInteger('user_id');

            // Monday - Saturday
            $table->string('day',20);

            // Pending / Completed
            $table->enum('status',[
                'pending',
                'in_progress',
                'completed'
            ])->default('pending');

            $table->timestamps();

            // Foreign Keys

            $table->foreign('seo_plan_client_id')
                ->references('id')
                ->on('seo_plan_clients')
                ->onDelete('cascade');

            $table->foreign('seo_plan_task_id')
                ->references('id')
                ->on('seo_plan_tasks')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_task_distributions');
    }
};
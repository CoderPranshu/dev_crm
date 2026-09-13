<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seo_team_works', function (Blueprint $table) {

            $table->id();

            $table->foreignId('seo_team_task_id')
                  ->constrained('seo_team_tasks')
                  ->cascadeOnDelete();

            $table->foreignId('seo_plan_task_id')
                  ->constrained('seo_plan_tasks')
                  ->cascadeOnDelete();

            $table->date('work_date');

            $table->enum('status', ['Pending', 'Completed'])
                  ->default('Pending');

            $table->timestamp('completed_at')->nullable();

            $table->text('remarks')->nullable();

            $table->string('attachment')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seo_team_works');
    }
};
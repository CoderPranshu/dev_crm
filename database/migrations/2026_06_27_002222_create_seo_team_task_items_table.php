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
        Schema::create('seo_team_task_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('seo_team_task_id');

            $table->unsignedBigInteger('seo_plan_task_id');

            $table->enum('status', ['Pending', 'Completed'])
                ->default('Pending');

            $table->timestamp('completed_at')->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->foreign('seo_team_task_id')
                ->references('id')
                ->on('seo_team_tasks')
                ->onDelete('cascade');

            $table->foreign('seo_plan_task_id')
                ->references('id')
                ->on('seo_plan_tasks')
                ->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_team_task_items');
    }
};

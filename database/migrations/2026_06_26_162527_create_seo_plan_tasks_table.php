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
        Schema::create('seo_plan_tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('seo_plan_id')
                ->constrained('seo_plans')
                ->cascadeOnDelete();

            $table->string('day'); 
            // monday, tuesday etc (string better for flexibility)

            $table->string('task_title');

            $table->integer('sort_order')->default(1);

            $table->boolean('status')->default(1);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_plan_tasks');
    }
};

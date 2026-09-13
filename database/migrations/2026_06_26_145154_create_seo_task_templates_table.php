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
        Schema::create('seo_task_templates', function (Blueprint $table) {
                $table->id();

                $table->foreignId('seo_plan_id')
                    ->constrained('seo_plans')
                    ->cascadeOnDelete();

                $table->tinyInteger('day')->comment('1=Monday,2=Tuesday,3=Wednesday,4=Thursday,5=Friday,6=Saturday');

                $table->string('task_title');

                $table->text('description')->nullable();

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
        Schema::dropIfExists('seo_task_templates');
    }
};

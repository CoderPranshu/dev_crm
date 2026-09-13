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
        Schema::create('seo_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seo_service_id')
                ->constrained('seo_services')
                ->cascadeOnDelete();

            $table->string('name');
            $table->integer('duration')->comment('Months');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('seo_plans');
    }
};

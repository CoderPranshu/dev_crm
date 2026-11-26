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
   public function up(): void
    {
        Schema::create('seo_project_state_groups', function (Blueprint $table) {
            $table->id();

            $table->foreignId('seo_plan_client_id')
                ->constrained('seo_plan_clients')
                ->onDelete('cascade');

            $table->string('name');

            $table->timestamps();

            $table->index('seo_plan_client_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_project_state_groups');
    }
};

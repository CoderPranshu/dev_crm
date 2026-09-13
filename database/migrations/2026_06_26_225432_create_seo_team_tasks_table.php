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
        Schema::create('seo_team_tasks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('seo_plan_client_id');

            $table->string('team_name');

            $table->json('week_days');

            $table->text('notes')->nullable();

            $table->enum('status',['Pending','In Progress','Completed'])
                  ->default('Pending');

            $table->timestamps();

            $table->foreign('seo_plan_client_id')
                    ->references('id')
                    ->on('seo_plan_clients')
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
        Schema::dropIfExists('seo_team_tasks');
    }
};

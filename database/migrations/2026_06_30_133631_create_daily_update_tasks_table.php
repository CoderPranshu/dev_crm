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
        Schema::create('daily_update_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('task_date');
            $table->time('task_time');
            $table->enum('status',['Pending','Completed'])->default('Pending');
            $table->enum('priority',['Low','Medium','High'])->default('Medium');
            $table->text('description')->nullable();
            $table->string('user_id')->nullable();
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
        Schema::dropIfExists('daily_update_tasks');
    }
};

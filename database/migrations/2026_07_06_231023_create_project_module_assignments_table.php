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
        Schema::create('project_module_assignments', function (Blueprint $table) {
            $table->id();
 
            $table->foreignId('project_module_id')
                ->constrained('project_modules')
                ->cascadeOnDelete();
 
            $table->foreignId('assigned_by')
                ->constrained('users')
                ->cascadeOnDelete();
 
            $table->foreignId('assigned_to')
                ->constrained('users')
                ->cascadeOnDelete();
 
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled'])
                ->default('pending');
 
            $table->text('reason')->nullable();
 
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
 
            $table->timestamps();
 
            $table->index(['project_module_id', 'status']);
            $table->index(['assigned_to', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_module_assignments');
    }
};

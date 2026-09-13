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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            // Project Source
            $table->enum('source', ['manual', 'deal'])->default('manual');

            // Deal ID (CRM Deal)
            $table->unsignedBigInteger('deal_id')->nullable();

            // Client Information
            $table->string('client_name');
            $table->string('company_name')->nullable();
            $table->string('office_name')->nullable();

            $table->string('phone',20);
            $table->string('alternate_phone',20)->nullable();

            $table->string('email')->nullable();
            $table->string('alternate_email')->nullable();

            $table->string('website')->nullable();
            $table->string('gst_number')->nullable();

            $table->text('address')->nullable();

            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();

            // Project Details
            $table->string('project_name');
            $table->longText('project_description')->nullable();

            // Department
            $table->foreignId('department_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // Lead Developer
            $table->foreignId('assigned_to')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Dates
            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();

            // Priority
            $table->enum('priority',[
                'Low',
                'Medium',
                'High',
                'Critical'
            ])->default('Medium');

            // Status
            $table->enum('status',[
                'Pending',
                'In Progress',
                'Completed',
                'On Hold',
                'Cancelled'
            ])->default('Pending');

            // Notes
            $table->longText('remarks')->nullable();

            // Created By
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
    
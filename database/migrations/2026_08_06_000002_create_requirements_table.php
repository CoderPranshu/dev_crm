<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_module_id')
                ->constrained('project_modules')
                ->cascadeOnDelete();

            $table->foreignId('requirement_type_id')
                ->constrained('requirement_types');

            $table->foreignId('raised_by')
                ->constrained('users');

            $table->string('title');
            $table->longText('description')->nullable();

            $table->enum('status', [
                'Pending', 'Seen', 'In Progress', 'Waiting Admin',
                'Waiting Client', 'Completed', 'Rejected',
            ])->default('Pending');

            $table->enum('priority', ['Low', 'Medium', 'High', 'Critical'])
                ->default('Medium');

            $table->boolean('is_blocker')->default(false);

            $table->enum('forwarded_to', ['none', 'admin', 'client'])
                ->default('none');

            $table->foreignId('seen_by')->nullable()->constrained('users');
            $table->timestamp('seen_at')->nullable();

            $table->timestamp('completed_at')->nullable();
            $table->foreignId('completed_by')->nullable()->constrained('users');

            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['project_module_id', 'status']);
            $table->index(['is_blocker']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requirements');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requirement_timelines', function (Blueprint $table) {
            $table->id();

            $table->foreignId('requirement_id')
                ->constrained('requirements')
                ->cascadeOnDelete();

            $table->enum('event_type', [
                'raised', 'seen', 'replied', 'forwarded_admin', 'forwarded_client',
                'file_uploaded', 'status_changed', 'completed', 'rejected', 'comment_added',
            ]);

            $table->foreignId('actor_id')->nullable()->constrained('users');

            $table->string('from_status')->nullable();
            $table->string('to_status')->nullable();

            $table->json('meta')->nullable();
            $table->string('description', 500);

            $table->timestamp('created_at')->useCurrent();

            $table->index(['requirement_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requirement_timelines');
    }
};

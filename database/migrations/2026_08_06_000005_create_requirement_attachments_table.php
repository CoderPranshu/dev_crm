<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requirement_attachments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('requirement_id')
                ->constrained('requirements')
                ->cascadeOnDelete();

            $table->foreignId('comment_id')->nullable()
                ->constrained('requirement_comments')
                ->cascadeOnDelete();

            $table->foreignId('uploaded_by')->constrained('users');

            $table->enum('uploaded_by_role', ['developer', 'lead', 'admin', 'client'])
                ->default('developer');

            $table->string('file_name');
            $table->string('file_path');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('mime_type')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();

            $table->index(['requirement_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requirement_attachments');
    }
};

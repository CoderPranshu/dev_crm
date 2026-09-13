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
        Schema::create('project_attachments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Original file name
            $table->string('original_name');

            // Saved file name
            $table->string('file_name');

            // Storage path
            $table->string('file_path');

            // Extension
            $table->string('extension',20)->nullable();

            // MIME Type
            $table->string('mime_type')->nullable();

            // Size in Bytes
            $table->bigInteger('file_size')->nullable();

            // Storage Disk
            $table->string('disk')->default('public');

            // Uploaded By
            $table->foreignId('uploaded_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

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
        Schema::dropIfExists('project_attachments');
    }
};


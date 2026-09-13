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
        Schema::create('project_message_files', function (Blueprint $table) {

            $table->id();

            $table->foreignId('project_message_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('original_name');

            $table->string('file_name');

            $table->string('file_path');

            $table->string('mime_type')->nullable();

            $table->bigInteger('file_size')->nullable();

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
        Schema::dropIfExists('project_message_files');
    }
};

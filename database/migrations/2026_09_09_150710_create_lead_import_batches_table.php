<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lead_import_batches', function (Blueprint $table) {
            $table->id();

            $table->string('original_file_name');
            $table->string('stored_file_name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            $table->unsignedInteger('total_rows')->default(0);
            $table->unsignedInteger('imported_rows')->default(0);
            $table->unsignedInteger('skipped_rows')->default(0);

            $table->unsignedBigInteger('sales_user_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();

            $table->string('status')->default('completed');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lead_import_batches');
    }
};
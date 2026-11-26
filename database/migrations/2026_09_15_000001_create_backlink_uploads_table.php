<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('backlink_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('backlink_category_id')->constrained('backlink_categories');
            $table->unsignedBigInteger('created_by')->index();
            $table->string('original_name');
            $table->string('path');
            $table->string('extension', 8);
            $table->unsignedBigInteger('size');
            $table->json('headers');
            $table->json('mapping')->nullable();
            $table->string('status', 16)->default('pending')->index();
            $table->unsignedInteger('imported')->default(0);
            $table->unsignedInteger('skipped')->default(0);
            $table->unsignedInteger('invalid')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('backlink_uploads'); }
};

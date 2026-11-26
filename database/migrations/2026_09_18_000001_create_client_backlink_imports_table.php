<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_backlink_imports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('seo_plan_client_id')
                ->constrained('seo_plan_clients')
                ->cascadeOnDelete();

            $table->foreignId('backlink_category_id')
                ->nullable()
                ->constrained('backlink_categories')
                ->nullOnDelete();

            $table->foreignId('uploaded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('original_name', 240);
            $table->string('path');
            $table->string('extension', 10);
            $table->unsignedBigInteger('size')->default(0);

            $table->json('headers');
            $table->json('mapping')->nullable();

            $table->unsignedInteger('total_rows')->default(0);
            $table->unsignedInteger('imported')->default(0);
            $table->unsignedInteger('skipped')->default(0);
            $table->unsignedInteger('invalid')->default(0);

            // pending -> file stored, mapping required
            // processing -> import is running
            // completed -> import finished
            // failed -> import failed
            $table->string('status', 20)->default('pending')->index();

            $table->text('error_message')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(
                ['seo_plan_client_id', 'created_at'],
                'client_backlink_imports_client_created_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_backlink_imports');
    }
};

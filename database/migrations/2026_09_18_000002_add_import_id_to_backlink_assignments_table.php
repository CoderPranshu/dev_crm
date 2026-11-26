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
        Schema::table('backlink_assignments', function (Blueprint $table) {
            $table->foreignId('client_backlink_import_id')
                ->nullable()
                ->after('seo_plan_client_id')
                ->constrained('client_backlink_imports')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('backlink_assignments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('client_backlink_import_id');
        });
    }
};

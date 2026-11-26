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
        Schema::table('seo_project_locations', function (Blueprint $table) {

            $table->foreignId('state_group_id')
                ->nullable()
                ->after('type')
                ->constrained('seo_project_state_groups')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('seo_project_locations', function (Blueprint $table) {

            $table->dropForeign(['state_group_id']);
            $table->dropColumn('state_group_id');

        });
    }
};

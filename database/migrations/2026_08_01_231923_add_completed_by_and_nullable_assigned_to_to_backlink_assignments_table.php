<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE backlink_assignments MODIFY assigned_to BIGINT UNSIGNED NULL');

        DB::statement('ALTER TABLE backlink_assignments ADD COLUMN completed_by BIGINT UNSIGNED NULL AFTER completed_at');

        DB::statement('ALTER TABLE backlink_assignments ADD CONSTRAINT backlink_assignments_completed_by_foreign FOREIGN KEY (completed_by) REFERENCES users(id) ON DELETE SET NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE backlink_assignments DROP FOREIGN KEY backlink_assignments_completed_by_foreign');
        DB::statement('ALTER TABLE backlink_assignments DROP COLUMN completed_by');
        DB::statement('ALTER TABLE backlink_assignments MODIFY assigned_to BIGINT UNSIGNED NOT NULL');
    }
};
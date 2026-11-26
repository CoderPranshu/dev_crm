<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->foreignId('subscription_id')
                ->nullable()
                ->constrained('subscriptions')
                ->nullOnDelete();
            $table->string('domain_name')->nullable();
        });

        // Existing tickets keep their department. New tickets have no department.
        // Code Sparrow uses MySQL; preserve the existing column's precise type
        // when changing only its nullability (e.g. bigint unsigned or int).
        $department = DB::selectOne("SHOW COLUMNS FROM `support_tickets` LIKE 'department'");

        if ($department && strtoupper((string) $department->Null) === 'NO') {
            $type = (string) $department->Type;

            if (!preg_match('/\A[a-zA-Z0-9(), ]+\z/', $type)) {
                throw new RuntimeException('Unexpected support_tickets.department column type.');
            }

            DB::statement("ALTER TABLE `support_tickets` MODIFY COLUMN `department` {$type} NULL");
        }
    }

    public function down(): void
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->dropForeign(['subscription_id']);
            $table->dropColumn(['subscription_id', 'domain_name']);
        });

        // Keep department nullable: tickets created after up() have no department.
    }
};
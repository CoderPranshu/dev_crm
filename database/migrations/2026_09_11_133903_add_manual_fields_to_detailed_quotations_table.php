<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detailed_quotations', function (Blueprint $table) {
            $table->string('quotation_type', 20)
                ->default('uploaded')
                ->after('name');

            $table->foreignId('category_id')
                ->nullable()
                ->after('quotation_type')
                ->constrained('quotation_categories')
                ->nullOnDelete();

            $table->foreignId('service_id')
                ->nullable()
                ->after('category_id')
                ->constrained('quotation_services')
                ->nullOnDelete();

            $table->decimal('price', 12, 2)
                ->nullable()
                ->after('service_id');

            $table->longText('content')
                ->nullable()
                ->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('detailed_quotations', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['service_id']);

            $table->dropColumn([
                'quotation_type',
                'category_id',
                'service_id',
                'price',
                'content',
            ]);
        });
    }
};


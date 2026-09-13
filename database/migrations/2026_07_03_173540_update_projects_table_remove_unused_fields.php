<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {

            // Remove Columns
            $table->dropColumn([
                'company_name',
                'office_name',
                'alternate_phone',
                'alternate_email',
                'website',
                'gst_number',
                'country',
                'state',
                'city',
                'zip_code',
            ]);

        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {

            $table->string('company_name')->nullable();

            $table->string('office_name')->nullable();

            $table->string('alternate_phone',20)->nullable();

            $table->string('alternate_email')->nullable();

            $table->string('website')->nullable();

            $table->string('gst_number')->nullable();

            $table->string('country')->nullable();

            $table->string('state')->nullable();

            $table->string('city')->nullable();

            $table->string('zip_code')->nullable();

        });
    }
};
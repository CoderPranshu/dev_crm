<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requirement_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        $types = [
            'API', 'Images', 'Logo', 'Payment Gateway', 'Hosting', 'Credentials',
            'SMTP', 'Firebase', 'Domain', 'Database', 'Content', 'Video',
            'Social Login', 'Google Map', 'WhatsApp API', 'Other',
        ];

        $now = now();

        DB::table('requirement_types')->insert(
            collect($types)->map(fn ($name, $i) => [
                'name' => $name,
                'sort_order' => $i,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ])->values()->all()
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('requirement_types');
    }
};

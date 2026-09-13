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
        Schema::create('on_page_seo_tasks', function (Blueprint $table) {

            $table->id();

            $table->foreignId('on_page_seo_category_id')
                ->constrained('on_page_seo_categories')
                ->cascadeOnDelete();

            $table->string('task_name');

            $table->string('slug')->unique();

            $table->enum('input_type', [

                'text',

                'textarea',

                'number',

                'url',

                'email',

                'select',

                'checkbox',

                'date',

                'file',

            ])->default('text');

            $table->text('placeholder')->nullable();

            $table->text('options')->nullable();

            $table->boolean('is_required')->default(false);

            $table->integer('sort_order')->default(0);

            $table->enum('status', [

                'active',

                'inactive',

            ])->default('active');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('on_page_seo_tasks');
    }
};
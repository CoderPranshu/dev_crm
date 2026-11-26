<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('special_days', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->date('occasion_date')->index();

            $table->string('category', 50)
                ->default('general')
                ->index();

            $table->string('icon', 20)->nullable();

            $table->boolean('is_major')
                ->default(false)
                ->index();

            $table->boolean('is_active')
                ->default(true)
                ->index();

            $table->timestamps();

            $table->unique(
                ['title', 'occasion_date'],
                'special_days_title_date_unique'
            );
        });
    }

    public function down()
    {
        Schema::dropIfExists('special_days');
    }
};


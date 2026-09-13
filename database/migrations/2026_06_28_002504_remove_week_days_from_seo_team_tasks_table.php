<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('seo_team_tasks', function (Blueprint $table) {
            $table->dropColumn('week_days');
        });
    }

    public function down()
    {
        Schema::table('seo_team_tasks', function (Blueprint $table) {
            $table->json('week_days')->nullable();
        });
    }
};
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
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table->string('client_name');

            $table->string('company_name')->nullable();

            $table->string('email')->nullable();

            $table->string('mobile')->nullable();

            $table->date('purchase_date');

            $table->integer('duration_months')->default(12);

            $table->date('expiry_date');

            $table->decimal('total_amount',10,2)->default(0);

            $table->integer('renew_before_days')->default(3);

            $table->enum('status',[
                'active',
                'expired',
                'renewal_due'
            ])->default('active');

            $table->text('remarks')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};

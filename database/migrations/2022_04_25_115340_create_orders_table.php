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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('foreign_currency_purchased');
            $table->float('foreign_currency_exchange_rate');
            $table->float('surcharge_percentage');
            $table->float('surcharge_amount');
            $table->float('foreign_currency_amount');
            $table->float('amount_in_usd');
            $table->float('discount_percentage');
            $table->float('discount_amount');
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};

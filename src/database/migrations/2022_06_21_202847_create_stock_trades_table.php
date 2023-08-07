<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_trades', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('shareholder_id')->nullable();
            $table->integer('symbol_id')->nullable();
            $table->bigInteger('tokens_quantity')->nullable();
            $table->bigInteger('token_price')->nullable();
            $table->bigInteger('trade_value')->nullable();
            $table->string('description')->nullable();
            $table->bigInteger('mutual_trade_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_trades');
    }
}

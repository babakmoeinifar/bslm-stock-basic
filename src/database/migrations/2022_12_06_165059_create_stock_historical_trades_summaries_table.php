<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockHistoricalTradesSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_historical_trades_summaries', function (Blueprint $table) {
            $table->id();
            $table->string('symbol_id');
            $table->timestamp('from_date');
            $table->timestamp('to_date');
            $table->string('title');
            $table->mediumInteger('min_stock_transfer_price')->nullable();
            $table->mediumInteger('max_stock_transfer_price')->nullable();
            $table->mediumInteger('min_stock_price')->nullable();
            $table->mediumInteger('max_stock_price')->nullable();
            $table->bigInteger('trades_total_value')->nullable();
            $table->mediumInteger('stock_weighted_average_price')->nullable();
            $table->integer('supply_volume')->nullable();
            $table->integer('demand_volume')->nullable();
            $table->integer('traded_volume')->nullable();
            $table->integer('highest_volume')->nullable();
            $table->smallInteger('number_of_traders')->nullable();
            $table->smallInteger('number_of_trades')->nullable();
            $table->smallInteger('number_of_suppliers')->nullable();
            $table->smallInteger('number_of_demanders')->nullable();
            $table->boolean('bull_or_bear_market')->nullable();
            $table->text('technical_analysis')->nullable();
            $table->text('fundamental_analysis')->nullable();
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
        Schema::dropIfExists('stock_historical_trades_summaries');
    }
}

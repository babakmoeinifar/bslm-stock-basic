<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StockChangePriceFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_esops', function (Blueprint $table) {
            $table->float('token_price', 10, 2)->change();
        });
        Schema::table('stock_symbol_changes', function (Blueprint $table) {
            $table->float('token_price', 10, 2)->change();
        });
        Schema::table('stock_trades', function (Blueprint $table) {
            $table->float('token_price', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_esops', function (Blueprint $table) {
            $table->double('token_price', 10, 2)->change();
        });
        Schema::table('stock_symbol_changes', function (Blueprint $table) {
            $table->double('token_price', 10, 2)->change();
        });
        Schema::table('stock_trades', function (Blueprint $table) {
            $table->double('token_price', 10, 2)->change();
        });
    }
}

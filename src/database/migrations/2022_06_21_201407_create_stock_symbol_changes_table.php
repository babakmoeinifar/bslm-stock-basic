<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockSymbolChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_symbol_changes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('symbol_id')->nullable();
            $table->bigInteger('token_price')->nullable();
            $table->bigInteger('stock_block_quantity')->nullable();
            $table->bigInteger('symbol_total_value')->nullable();
            $table->string('description')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_symbol_changes');
    }
}

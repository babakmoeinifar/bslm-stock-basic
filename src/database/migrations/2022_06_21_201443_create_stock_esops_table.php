<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockEsopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_esops', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('contracted_at')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('shareholder_id')->nullable();
            $table->integer('symbol_id')->nullable();
            $table->integer('tokens_quantity')->nullable();
            $table->integer('token_price')->nullable();
            $table->integer('esop_value')->nullable();
            $table->string('vesting_rule')->nullable();
            $table->timestamp('will_vest_at')->nullable();
            $table->string('title')->nullable();
            $table->timestamp('vested_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->string('expiration_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_esops');
    }
}

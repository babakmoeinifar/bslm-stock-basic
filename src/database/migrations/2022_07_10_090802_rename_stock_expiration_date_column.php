<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameStockExpirationDateColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_esops', function(Blueprint $table) {
            $table->renameColumn('expiratoin_description', 'expiration_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_esops', function(Blueprint $table) {
            $table->renameColumn('expiration_description', 'expiratoin_description');
        });
    }
}

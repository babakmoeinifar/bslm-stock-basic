<?php

namespace Bslm\Stock\Http\Models;

use Illuminate\Database\Eloquent\Model;

class StockEsops extends Model
{
    public $table = 'stock_esops';

    public function shareholder()
    {
        return $this->belongsTo(StockShareholders::class);
    }
}

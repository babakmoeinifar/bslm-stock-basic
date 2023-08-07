<?php

namespace Bslm\Stock\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Bslm\Stock\Http\Models\StockShareholders;

class StockShareholdersController extends Controller
{
    public static function amIShareholder() {
        $res = StockShareholders::query()
        ->where('person_id', auth()->user()->id)
        ->get();
        foreach($res as $item)
            return true;
        return false;
    }
}

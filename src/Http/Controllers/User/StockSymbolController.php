<?php

namespace Bslm\Stock\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Bslm\Stock\Http\Models\StockSymbols;

class StockSymbolController extends Controller
{
    public static function getBySlug($slug)
    {
        $data = StockSymbols::select()
            ->where('symbol_identifier', $slug)
            ->firstOrFail();
        return [
            'id' => $data->id,
            'company_name' => $data->company_name,
            'slug' => $data->symbol_identifier
        ];
    }
}

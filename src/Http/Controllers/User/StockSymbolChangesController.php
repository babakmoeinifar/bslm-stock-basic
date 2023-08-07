<?php

namespace Bslm\Stock\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Bslm\Stock\Http\Models\StockSymbolChanges;
use Illuminate\Support\Facades\DB;

class StockSymbolChangesController extends Controller
{

    public static function getLastPrice($symbol_id=null) {
        /**
         * returns: null | number | array
         */
        if($symbol_id)
        {
            $data = StockSymbolChanges::select()
            ->where('symbol_id', $symbol_id)
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first();
            return @$data->token_price;
        }

        $data = DB::select("
        select symbol_id, token_price, stock_symbols.symbol_identifier 
        from( 
            select symbol_id, token_price, ROW_NUMBER() OVER(PARTITION BY symbol_id ORDER BY id desc) as rn
            from stock_symbol_changes ) as a, stock_symbols
        where symbol_id = stock_symbols.id
        AND rn = 1
        ");
        $return = [];
        foreach($data as $item)
        {
            $return[$item->symbol_id] = [
                'symbol_id'         => $item->symbol_id,
                'token_price'       => $item->token_price,
                'symbol_identifier' => $item->symbol_identifier
            ];
        }
        return $return;

    }

    public function changes($slug) {

        amIShareholder();

        // get token data
        $data['symbol'] = StockSymbolController::getBySlug($slug);

        $data['changes'] = StockSymbolChanges::select('stock_symbol_changes.*')
        ->join('stock_symbols', 'stock_symbols.id', '=', 'symbol_id')
        ->where('stock_symbols.symbol_identifier', $slug)
        ->orderBy('updated_at', 'asc')
        ->paginate(30);

        // prepare summary
        $data['summary'] = StockTradesController::summary();

        return view('stock::user.stock.symbolchange', ['data' => $data]);
    }

    public static function historicalChanges($symbol_id) {

        $return = [];

        $result = StockSymbolChanges::select('created_at', 'token_price')
        ->where('symbol_id', $symbol_id)
        ->orderBy('created_at', 'asc')
        ->get();

        foreach($result as $item)
        {
            $return['labels'][] = jdf($item->created_at);
            $return['values'][] = (double)$item->token_price;
        }
        return $return;
    }
}

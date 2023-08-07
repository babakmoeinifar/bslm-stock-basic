<?php

namespace Bslm\Stock\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Bslm\Stock\Http\Models\StockEsops;

class StockEsopsController extends Controller
{
    public static function moreInfo() {

        amIShareholder();
        
        return view('stock::user.stock.more-info');
    }

    public function get($id) {
        // $res = DB::select("select * from stock_esops");
        // print_r($res[0]); exit;
        // var_dump( StockEsops::$table ); exit;
        $res = StockEsops::select()
        ->where('id', $id)
        ->with(['symbol'])
        // ->get();
        ->first();
        print_r($res->symbol);
        // return view('user.kudos.index', $data);
    }

    public function esops() {

        amIShareholder();

        // get token data
       $data['symbol'] = StockSymbolController::getBySlug('BSLM');

        // prepare summary
        $data['summary'] = StockTradesController::summary();

        $data['esops'] = StockEsops::select('stock_esops.*')
        ->join('stock_shareholders', 'stock_shareholders.id', '=', 'shareholder_id')
        ->where('stock_shareholders.person_id', Auth()->id())
        ->paginate(30);

        return view('stock::user.stock.esops', ['data' => $data]);
    }

    public static function nonVestedValue($symbol_id=null) {

        /* return: number | sum of esop_values */

        $data = StockEsops::select('stock_esops.*')
        ->join('stock_shareholders', 'stock_shareholders.id', '=', 'shareholder_id')
        ->where('stock_shareholders.person_id', Auth()->id())
        ->where('vested_at', NULL)
        ->where('expired_at', NULL)
        ->sum('esop_value');

        return $data;
    }

    public static function nonVestedCount($symbol_id=null) {

        $data = StockEsops::select('stock_esops.*')
        ->join('stock_shareholders', 'stock_shareholders.id', '=', 'shareholder_id')
        ->where('stock_shareholders.person_id', Auth()->id())
        ->where('vested_at', NULL)
        ->where('expired_at', NULL)
        ->sum('tokens_quantity');
        return $data;

    }

}

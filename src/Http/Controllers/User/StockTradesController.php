<?php

namespace Bslm\Stock\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Bslm\Stock\Http\Models\StockEsops;
use Bslm\Stock\Http\Models\StockHistoricalTradesSummary;
use Bslm\Stock\Http\Models\StockSymbolChanges;
use Bslm\Stock\Http\Models\StockSymbols;
use Bslm\Stock\Http\Models\StockTrades;
use Bslm\Stock\Http\Notifications\expireEsop;
use Bslm\Stock\Http\Notifications\newEsop;
use Bslm\Stock\Http\Notifications\stockTrade;
use Illuminate\Support\Facades\DB;

class StockTradesController extends Controller
{

    public static function summary()
    {
        $slug = 'BSLM';

        $data['symbol'] = StockSymbolController::getBySlug($slug);

        // get now price
        $data['symbol']['now_price'] = StockSymbolChangesController::getLastPrice($data['symbol']['id']);
        $data['symbol']['chart'] = StockSymbolChangesController::historicalChanges($data['symbol']['id']);

        // get non vested
        $count = StockEsopsController::nonVestedCount();
        $data['non-vested'] = [
            'old' => StockEsopsController::nonVestedValue(),
            'new' => $count * $data['symbol']['now_price'],
            'count' => $count
        ];

        $count = self::sumCount(auth()->user()->id, 1 /*BSLM*/);
        $data['vested'] = [
            'old' => self::sumValues(),
            'new' => $count * $data['symbol']['now_price'],
            'count' => $count
        ];

        $data['now_price'] = $data['symbol']['now_price'];

        $data['changes'] = StockSymbolChanges::select('stock_symbol_changes.*')
            ->join('stock_symbols', 'stock_symbols.id', '=', 'symbol_id')
            ->where('stock_symbols.symbol_identifier', $slug)
            ->orderBy('updated_at', 'desc')
            ->paginate(30);

        $trades = StockTrades::select([
            DB::raw('stock_trades.id'),
            DB::raw('stock_trades.created_at as contracted_at'),
            DB::raw('null as created_at'),
            DB::raw('null as updated_at'),
            DB::raw('null as created_by'),
            DB::raw('null as shareholder_id'),
            DB::raw('null as symbol_id'),
            DB::raw('stock_trades.tokens_quantity as tokens_quantity'),
            DB::raw('null as token_price'),
            DB::raw('stock_trades.trade_value as esop_value'),
            DB::raw('null as vesting_rule'),
            DB::raw('null as will_vest_at'),
            DB::raw('stock_trades.description as title'),
            DB::raw('stock_trades.created_at as vested_at'),
            DB::raw('null as expired_at'),
//            DB::raw('null as expiration_description'),
            DB::raw('stock_trades.bank_receipt as bank_receipt'),
        ])
            ->join('stock_shareholders', 'stock_shareholders.id', '=', 'shareholder_id')
            ->where('stock_shareholders.person_id', Auth()->id());

        $data['esops'] = StockEsops::select('stock_esops.*')
            ->join('stock_shareholders', 'stock_shareholders.id', '=', 'shareholder_id')
            ->where('stock_shareholders.person_id', Auth()->id())
            ->where('vested_at', null)
            ->union($trades)
            ->orderBy('contracted_at', 'asc')
            ->paginate(30);

        return $data;
    }

    public static function dashboard()
    {
        amIShareholder();
        markReadNotification(stockTrade::class);
        markReadNotification(newEsop::class);
        markReadNotification(expireEsop::class);

        $data = self::summary();
        return view('stock::user.stock.dashboard', ['data' => $data]);
    }

    public function trades()
    {
        amIShareholder();

        // get token data
        $data['symbol'] = StockSymbolController::getBySlug('BSLM');

        // prepare summary
        $data['summary'] = self::summary();

        $data['trades'] = StockTrades::select('stock_trades.*')
            ->join('stock_shareholders', 'stock_shareholders.id', '=', 'shareholder_id')
            ->where('stock_shareholders.person_id', Auth()->id())
            ->paginate(30);


        return view('stock::user.stock.trades', ['data' => $data]);

    }

    public static function sumValues($symbol_id = null)
    {
        $data = StockTrades::select('stock_trades.*')
            ->join('stock_shareholders', 'stock_shareholders.id', '=', 'shareholder_id')
            ->where('stock_shareholders.person_id', Auth()->id())
            ->where('trade_value', '>', 0)
            ->sum('trade_value');
        return $data;

    }

    public static function sumCount($userid, $symbol_id)
    {

        $data = StockTrades::select('stock_trades.*')
            ->join('stock_shareholders', 'stock_shareholders.id', '=', 'shareholder_id')
            ->where('stock_shareholders.person_id', $userid)
            ->where('symbol_id', $symbol_id)
            ->sum('tokens_quantity');
        return $data;

    }

    public function symbolPage($slug = null)
    {
        if ($slug === null) {
            $slug = request('slug');
            return redirect('stock/symbol/' . $slug);
        }
        $data['symbol'] = StockSymbolController::getBySlug($slug);

        // get now price
        $data['symbol']['now_price'] = StockSymbolChangesController::getLastPrice($data['symbol']['id']);
        $data['symbol']['chart'] = StockSymbolChangesController::historicalChanges($data['symbol']['id']);

        $data['now_price'] = $data['symbol']['now_price'];

        $data['changes'] = StockSymbolChanges::select('stock_symbol_changes.*')
            ->join('stock_symbols', 'stock_symbols.id', '=', 'symbol_id')
            ->where('stock_symbols.symbol_identifier', $slug)
            ->orderBy('updated_at', 'desc')
            ->paginate(30);

        $data['symbols'] = StockSymbols::get();

        $data['histories'] = StockHistoricalTradesSummary::where('symbol_id', $data['symbol']['id'])
            ->orderBy('from_date', 'DESC')->get();
        $rawHistories = StockHistoricalTradesSummary::where('symbol_id', $data['symbol']['id'])->orderBy('from_date', 'ASC')->get();

        //chart
        $labels = [];
        foreach ($rawHistories as $history) {
            $labels[] = (jdf_format($history->from_date, 'Y/m/d'));
        }
        $data['trades_total_value'] = collect($rawHistories->map->trades_total_value)->toArray();
        $data['stock_weighted_average_price'] = collect($rawHistories->map->stock_weighted_average_price)->toArray();

        return view('stock::user.stock.symbol-page', ['data' => $data, 'labels' => $labels]);
    }

    public function mainDashboard()
    {
        $data = [];
        $data['notifications'] = auth()->user()->unreadNotifications()->get();
        return view('stock::user.stock.mainDashboard', $data);
    }

}
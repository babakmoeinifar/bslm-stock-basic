<?php

namespace Bslm\Stock\Http\Controllers\Admin;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Bslm\Stock\Http\Controllers\User\StockSymbolChangesController as u;
use Bslm\Stock\Http\Models\StockHistoricalTradesSummary;
use Bslm\Stock\Http\Models\StockShareholders;
use Bslm\Stock\Http\Models\StockSymbols;
use Bslm\Stock\Http\Models\StockTrades;
use Illuminate\Http\Request;

class StockTradesController extends Controller
{
    public function index(Request $request, $userid = null)
    {
        is_allowed('stock');

        if ($userid) {
            $data['trades'] = StockTrades::select('stock_trades.*')
                ->join('stock_shareholders', 'stock_shareholders.id', '=', 'shareholder_id')
                ->where('stock_shareholders.person_id', $userid)
                ->paginate(30);
        } else {
            $data['trades'] = StockTrades::select()->paginate(30);
        }

        $data['users'] = UserController::getList();
        $data['userid'] = $userid;
        $data['now_prices'] = $price = u::getLastPrice();
        $data['shareholders'] = StockShareholders::all();

        return view('stock::admin.stock.trades', ['data' => $data]);
    }


    public function trade(Request $request)
    {
        is_allowed('stock');

        $request->validate([
            'shareholder' => 'string',
            'employee' => 'string',
            'count' => 'string',
            'price' => 'string'
        ]);

        $count = toEnglish((int)$request->get('count'));
        $price = toEnglish($request->get('price'));

        $seller = User::find(StockShareholders::select()->where('id', $request->get('shareholder'))->first()->person_id);
        $buyer = User::find($request->get('employee'));

        return StockTrades::trade(
            $request->get('shareholder'),
            $request->get('employee'),
            1,
            $count,
            $price,
            $count * $price,
            $request->get('bank_receipt', null),
            "فروش سهام به " . $buyer->name,
            "خرید سهام از " . ($seller->name ?? $shareholder->id),
            null,
            null,
            false,
            null,
            $seller,
            $buyer
        );

    }

    /********* Trade History **********/
    public function tradeHistory()
    {
        is_allowed('stock');
        $data['histories'] = StockHistoricalTradesSummary::paginate(30);
        return view('stock::admin.stock.tradesHistory.index', $data);
    }

    public function tradeHistoryCreate(Request $request)
    {
        is_allowed('stock');

        return view('stock::admin.stock.tradesHistory.create',
            ['history' => new StockHistoricalTradesSummary(), 'symbols' => StockSymbols::all()]);
    }

    public function tradeHistoryCreateSubmit(Request $request)
    {
        is_allowed('stock');

        $request->validate([
            'title' => 'required|string',
            'symbol_id' => 'required',
            'date_start_alt' => 'required',
            'date_end_alt' => 'required',
        ]);

        $data = $request->all();

        $data['bull_or_bear_market'] = $request->get('bull_or_bear_market') == 1 ? 1 : 0;
        $data['from_date'] = date("Y-m-d", $request->get('date_start_alt'));
        $data['to_date'] = date("Y-m-d", $request->get('date_end_alt'));

        StockHistoricalTradesSummary::create($data);

        return redirect('/admin/stock/trades-history')->with('msg-ok', __('msg.add_ok', ['name' => $request->get('title')]));
    }

    public function tradeHistoryEdit(Request $request, $id)
    {
        is_allowed('stock');

        return view('stock::admin.stock.tradesHistory.edit',
            ['history' => StockHistoricalTradesSummary::findOrFail($id), 'symbols' => StockSymbols::all()]);
    }

    public function tradeHistoryEditSubmit(Request $request, $id)
    {
        is_allowed('stock');

        $history = StockHistoricalTradesSummary::find($id);
        $request->validate([
            'title' => 'required|string',
            'symbol_id' => 'required',
            'date_start_alt' => 'required',
            'date_end_alt' => 'required',
        ]);

        $data = $request->all();

        $data['bull_or_bear_market'] = $request->get('bull_or_bear_market') == 1 ? 1 : 0;
        $data['from_date'] = date("Y-m-d", $request->get('date_start_alt'));
        $data['to_date'] = date("Y-m-d", $request->get('date_end_alt'));
        $history->update($data);

        return redirect()->back()->with('msg-ok', __('msg.edit_ok'));
    }

    public function tradeHistoryDestroy($id)
    {
        is_allowed('stock');

        $history = StockHistoricalTradesSummary::find($id);
        $history->delete();

        return redirect()->back()->with('msg-ok', __('msg.item_deleted'));
    }
}

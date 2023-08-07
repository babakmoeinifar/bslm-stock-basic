<?php

namespace Bslm\Stock\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Bslm\Stock\Http\Controllers\User\StockSymbolChangesController as u;
use Bslm\Stock\Http\Models\StockSymbolChanges;
use Bslm\Stock\Http\Models\StockSymbols;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StockSymbolChangesController extends Controller
{
    public function index(Request $request, $slug = null)
    {
        is_allowed('stock');

        if (!$slug) {
            $slug = StockSymbols::first()->value('symbol_identifier');
        }

        // get token data
        $data['symbol'] = StockSymbolController::getBySlug($slug);

        // get symbols
        $data['symbols'] = StockSymbols::all();

        $data['changes'] = StockSymbolChanges::select('stock_symbol_changes.*')
            ->join('stock_symbols', 'stock_symbols.id', '=', 'symbol_id')
            ->where('stock_symbols.symbol_identifier', $slug)
            ->orderBy('updated_at', 'asc')
            ->paginate(30);

        return view('stock::admin.stock.symbolchange', ['data' => $data]);
    }

    public function edit(Request $request, $id)
    {
        is_allowed('stock');

        $data = StockSymbolChanges::select()->where('id', $id)->first();
        return view('stock::admin.stock.symbolchange-edit', ['data' => $data]);
    }

    public function lastPrice(Request $request, $symbol_id = null)
    {
        is_allowed('stock');

        $price = u::getLastPrice($symbol_id);

        return response()->json([
            'data'    => [
                'price' => $price,
            ],
            'code'    => 1,
            'message' => 'ok',
        ]);
    }

    public function editSubmit(Request $request)
    {
        is_allowed('stock');

        $request->validate([
            'id'                   => ['required', 'string'],
            'date_alt'             => ['required', 'string'],
            'description'          => ['required', 'string'],
            'symbol_total_value'   => ['required', 'string'],
            'stock_block_quantity' => ['required', 'string'],
        ]);

        $item                       = StockSymbolChanges::find($request->get('id'));
        $item->created_at           = Carbon::createFromTimestamp($request->get('date_alt'))->toDateTimeString();
        $item->updated_at           = Carbon::createFromTimestamp($request->get('date_alt'))->toDateTimeString();
        $item->description          = $request->get('description');
        $item->symbol_total_value   = $request->get('symbol_total_value');
        $item->stock_block_quantity = $request->get('stock_block_quantity');
        $item->token_price          = $request->get('symbol_total_value') / $request->get('stock_block_quantity');
        $item->save();

        return redirect()->back()->with('msg-ok', __('msg.edit_ok'));
    }

    public function new(Request $request, $slug)
    {
        is_allowed('stock');

        $data['slug'] = $slug;
        return view('stock::admin.stock.symbolchange-new', ['data' => $data]);
    }

    public function newSubmit(Request $request)
    {
        is_allowed('stock');

        $request->validate([
            'date_alt'             => ['required', 'string'],
            'slug'                 => ['required', 'string'],
            'description'          => ['required', 'string'],
            'symbol_total_value'   => ['required', 'string'],
            'stock_block_quantity' => ['required', 'string'],
        ]);

        $symbolDetails = StockSymbolController::getBySlug($request->get('slug'));

        // get last prev item
        $prev = self::prev($symbolDetails['id']);

        $stock_block_quantity = @$prev->stock_block_quantity + intval($request->get('stock_block_quantity'));
        $symbol_total_value   = @$prev->symbol_total_value + intval($request->get('symbol_total_value'));
        $token_price          = $symbol_total_value / $stock_block_quantity;

        $item                       = new StockSymbolChanges();
        $item->created_at           = Carbon::createFromTimestamp($request->get('date_alt'))->toDateTimeString();
        $item->updated_at           = Carbon::createFromTimestamp($request->get('date_alt'))->toDateTimeString();
        $item->symbol_id            = $symbolDetails['id'];
        $item->description          = $request->get('description');
        $item->stock_block_quantity = $stock_block_quantity;
        $item->symbol_total_value   = $symbol_total_value;
        $item->token_price          = $token_price;
        $item->save();

        return redirect("/admin/stock/symbolChanges/$symbolDetails[slug]")->with('msg-ok', "عملیات انجام شد");
    }

    public function prev($symbol_id)
    {
        is_allowed('stock');

        $res = StockSymbolChanges::select()
            ->where('symbol_id', $symbol_id)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->first();
        return $res;
    }
}

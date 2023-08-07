<?php

namespace Bslm\Stock\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Bslm\Stock\Http\Models\StockSymbols;
use Illuminate\Http\Request;

class StockSymbolController extends Controller
{

    public static function getBySlug($slug)
    {
        is_allowed('stock');

        $data = StockSymbols::select()
            ->where('symbol_identifier', $slug)
            ->first();
        return [
            'id'           => $data->id ?? '',
            'company_name' => $data->company_name ?? '',
            'slug'         => $data->symbol_identifier ?? '',
        ];
    }

    public function index(Request $request)
    {
        $data['symbols'] = StockSymbols::select()
            ->paginate(30);

        return view('stock::admin.stock.symbol', ['data' => $data]);
    }

    public function new(Request $request)
    {
        return view('stock::admin.stock.symbol-new');
    }

    public function newSubmit(Request $request)
    {
        $request->validate([
            'identifier' => ['required', 'string'],
            'company'    => ['required', 'string'],
        ]);

        $item                    = new StockSymbols();
        $item->symbol_identifier = $request->get('identifier');
        $item->company_name      = $request->get('company');
        $item->save();

        return redirect('/admin/stock/symbol')->with('msg-ok', 'نماد افزوده شد');
    }

    public function edit(Request $request, $id)
    {
        $data = StockSymbols::select()->where('id', $id)->first();
        return view('stock::admin.stock.symbol-edit', ['data' => $data]);
    }

    public function editSubmit(Request $request)
    {
        $request->validate([
            'id'         => ['required', 'string'],
            'identifier' => ['required', 'string'],
            'company'    => ['required', 'string'],
        ]);

        $item                    = StockSymbols::find($request->get('id'));
        $item->symbol_identifier = $request->get('identifier');
        $item->company_name      = $request->get('company');
        $item->save();

        return redirect('/admin/stock/symbol')->with('msg-ok', __('msg.edit_ok'));
    }
}

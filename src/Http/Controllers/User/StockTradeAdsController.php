<?php

namespace Bslm\Stock\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Bslm\Stock\Http\Models\TradeAds;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StockTradeAdsController extends Controller
{
    public function index()
    {

        $data['trades-buy'] = TradeAds::select(['stock_trade_ads.*', 'users.certman_username', 'users.mobile', 'users.name as creator_name', 'users.employee_id'])
            ->join('users', 'users.id', '=', 'user_id')
            ->where('trade_type', 1)
            ->where('stock_trade_ads.deleted_at', null)
            ->orderBy('token_price', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();

        $data['trades-sell'] = TradeAds::select(['stock_trade_ads.*', 'users.certman_username', 'users.mobile', 'users.name as creator_name', 'employee_id'])
            ->join('users', 'users.id', '=', 'user_id')
            ->where('trade_type', -1)
            ->where('stock_trade_ads.deleted_at', null)
            ->orderBy('token_price', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        $range = getUserConfig(0, 'trade-price-range');
        $range = explode('-', $range);
        $data['min'] = @$range[0];
        $data['max'] = @$range[1];

        $data['symbol'] = DB::select("
        select symbol_id, token_price, stock_symbols.symbol_identifier 
        from( 
            select symbol_id, token_price, ROW_NUMBER() OVER(PARTITION BY symbol_id ORDER BY id desc) as rn
            from stock_symbol_changes ) as a, stock_symbols
        where symbol_id = stock_symbols.id
        AND rn = 1
        ");

        $data['stock-trade-ads-top-text'] = getUserConfig(0, 'stock-trade-ads-top-text');

        return view('stock::user.tradeads.index', ['data' => $data]);
    }

    public function delete()
    {
        $tradeId = request('trade');
        if (is_admin()) {
            TradeAds::select()
                ->where('id', $tradeId)
                ->update(['deleted_at' => Carbon::now()]);
        } else {
            TradeAds::select()
                ->where('id', $tradeId)
                ->where('user_id', auth()->user()->id)
                ->update(['deleted_at' => Carbon::now()]);
        }

        return redirect("/stock/tradeAds/")->with('msg-ok', __('msg.tradeAd_removed'));
    }

//    public static function goForTrade(Request $request)
//    {
//
//        $request->validate([
//            'id' => 'string'
//        ]);
//
//        $item = TradeAds::find($request->get('id'));
//
//        $from_user = User::findOrFail(auth()->user()->id);
//        $to_user = User::findOrFail($item->user_id);
//
//        $sms1 = [
//            'to' => [
//                $from_user->mobile,
//            ],
//            'text' => "سلام. شما قصد معامله سهام با {$to_user->name} دارید. با ایشان {$to_user->mobile} گفتگو کنید و پس از توافق به px@basalam.com جزییات معامله را بگویید تا نقل و انتقال انجام شود.\nتیم px"
//        ];
//
//        $sms2 = [
//            'to' => [
//                $from_user->mobile,
//            ],
//            'text' => "سلام. {$from_user->name} قصد معامله سهام با شما دارد و با شما ارتباط خواهد گرفت.\nتیم px"
//        ];
//
//        return response()->json([
//            'data' => null,
//            'code' => 1,
//            'message' => 'ok',
//        ]);
//    }

    public static function newTradeAd(Request $request)
    {

        $request->validate([
            'type' => 'required|string',
            'count' => 'required|string',
            'price' => 'required|string'
        ]);

        $type = (int)toEnglish($request->get('type'));
        $count = (int)toEnglish($request->get('count'));
        $price = (int)toEnglish($request->get('price'));

        if ($count < 1) {
            return response()->json([
                'data' => null,
                'code' => 0,
                'message' => "تعداد مثقال نامعتبر است",
            ]);
        }

        $range = getUserConfig(0, 'trade-price-range');

        $range = explode('-', $range);
        if ($price < @$range[0] || $price > @$range[1]) {
            return response()->json([
                'data' => null,
                'code' => 0,
                'message' => "قیمت مثقال می تواند بین $range[0] و $range[1] باشد",
            ]);
        }

        // sell
        if ($type == -1) {
            $vested_stock = StockTradesController::sumCount(auth()->user()->id, 1/*BSLM*/);
            $advertised_stock = self::advertisedCount(auth()->user()->id);
            if ($vested_stock - $advertised_stock < $count) {
                // error
                return response()->json([
                    'data' => null,
                    'code' => 0,
                    'message' => "مقدار آگهی بیشتر از دارایی شماست",
                ]);
            }
        }

        $item = new TradeAds;
        $item->user_id = auth()->user()->id;
        $item->symbol_id = 1;
        $item->token_price = $price;
        $item->token_quantity = $count;
        $item->trade_type = $type;
        $item->save();

        return response()->json([
            'data' => null,
            'code' => 1,
            'message' => 'ok',
        ]);

    }

    public static function advertisedCount($userid)
    {
        return TradeAds::select('stock_trades.*')
            ->where('user_id', $userid)
            ->where('deleted_at', null)
            ->where('trade_type', -1)
            ->sum('token_quantity');
    }

    public function tradeGuide()
    {
        $data = getUserConfig(0, 'stock-trading-guide');

        return view('stock::user.tradeads.trade-guide', compact('data'));
    }
}

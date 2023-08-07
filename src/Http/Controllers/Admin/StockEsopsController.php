<?php

namespace Bslm\Stock\Http\Controllers\Admin;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Bslm\Stock\Http\Controllers\User\StockSymbolChangesController as u;
use Bslm\Stock\Http\Models\StockEsops;
use Bslm\Stock\Http\Models\StockShareholders;
use Bslm\Stock\Http\Models\StockSymbols;
use Bslm\Stock\Http\Models\StockTrades;
use Bslm\Stock\Http\Notifications\expireEsop;
use Bslm\Stock\Http\Notifications\newEsop;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class StockEsopsController extends Controller
{
    public function index($userid = null)
    {
        is_allowed('stock');

        if ($userid) {
            $data['esops'] = StockEsops::select('stock_esops.*')
                ->join('stock_shareholders', 'stock_shareholders.id', '=', 'shareholder_id')
                ->where('stock_shareholders.person_id', $userid)
                ->paginate(30);
        } else {
            $data['esops'] = StockEsops::with('shareholder')->select()->paginate(30);
        }

        $data['users'] = UserController::getList();
        $data['userid'] = $userid;

        return view('stock::admin.stock.esops', ['data' => $data]);
    }

    public function edit(Request $request/*, $userid*/, $esopid)
    {
        is_allowed('stock');

        $data = [];

        $data['symbols'] = StockSymbols::all();

        $data['data'] = StockEsops::select()
            ->where('id', $esopid)
            ->first();

        $data['users'] = $data['users'] = UserController::getList();

        $data['now_price'] = u::getLastPrice($data['data']->symbol_id);

        return view('stock::admin.stock.esops-edit', ['data' => $data]);
    }

    public function editSubmit(Request $request, $esopid)
    {
        is_allowed('stock');

        $request->validate([
            'select_new_esop_symbol' => ['required', 'string'],
            'title' => ['required', 'string'],
            'quantity' => ['required', 'string'],
            'vesting_rule' => ['required', 'string'],
            'vest_at_alt' => ['required', 'string'],
            'token_price' => ['required'],
        ]);

        $now_price = u::getLastPrice($request->get('select_new_esop_symbol'));

        $item = StockEsops::find($esopid);

        $userid = StockShareholdersController::getByUserShareholderId($item->shareholder_id);

        $quantity = (int)toEnglish($request->get('quantity'));
        $item->symbol_id = $request->get('select_new_esop_symbol');
        $item->contracted_at = Carbon::createFromTimestamp($request->get('contracted_at_alt'))->toDateTimeString();
        $item->symbol_id = $request->get('select_new_esop_symbol');
        $item->tokens_quantity = $quantity;
        $item->token_price = toEnglish($request->get('token_price'));
        $item->esop_value = toEnglish($request->get('token_price')) * $quantity;
        $item->vesting_rule = $request->get('vesting_rule');
        $item->will_vest_at = Carbon::createFromTimestamp($request->get('vest_at_alt'))->startOfDay()->toDateTimeString();
        $item->title = $request->get('title');

        $item->save();

        return redirect("/admin/stock/esops/$userid")->with('msg-ok', __('msg.edit_ok'));
    }

    public function vestSubmit($esopid)
    {
        is_allowed('stock');

        $esopDetails = StockEsops::select()->where('id', $esopid)->first();

        if ($esopDetails->vested_at) {
            return response()->json(['data' => null, 'code' => 0, 'message' => 'این قرارداد ثبلا vest شده',]);
        }

        $will_vest = Carbon::createFromFormat('Y-m-d H:i:s', $esopDetails['will_vest_at']);
        if ($will_vest > Carbon::now()) {
            return response()->json(['data' => null, 'code' => 0, 'message' => 'مهلت vest فرا نرسیده است',]);
        }
        return StockTrades::trade(
            getUserConfig(0, 'stock-option-pool-shareholder-id'),
            $esopDetails->shareholder_id,
            $esopDetails->symbol_id,
            $esopDetails->tokens_quantity,
            $esopDetails->token_price,
            $esopDetails->esop_value,
            null,
            $esopDetails->title,
            $esopDetails->title,
            null,
            " مثقال سهام برای شما vest شد.",
            true,
            $esopDetails
        );
    }

    public function expireSubmit(Request $request, $esopId)
    {
        is_allowed('stock');

        $request->validate([
            'expiration_description' => 'required|string',
            'expired_at' => 'required|string',
        ]);
        $expiredAt = date("Y-m-d", $request->get('expired_at'));
        StockEsops::where('id', $esopId)->update([
            'expiration_description' => $request->get('expiration_description'),
            'expired_at' => $expiredAt,
        ]);

        $shareHolder = StockShareholders::find($request->shareholderId);
        $user = User::where('id', $shareHolder->person_id)->first();
        $user->notify(new expireEsop($request->get('esopTitle')));

        return back()->with('msg-ok', __('msg.esop_expire', ['name' => $request->get('esopTitle')]));
    }

    public function new($userid = null)
    {
        is_allowed('stock');

        if ($userid) {
            $data['user'] = User::select()->where('id', $userid)->first();
        }

        $data['users'] = UserController::getList();
        $data['userid'] = $userid;

        $data['symbols'] = StockSymbols::all();

        return view('stock::admin.stock.esops-new', ['data' => $data]);
    }

    public function newSubmit(Request $request)
    {
        is_allowed('stock');

        $request->validate([
            'select-user' => ['required', 'string'],
            'select_new_esop_symbol' => ['required', 'string'],
            'title' => ['required', 'string'],
            'quantity' => ['required', 'numeric'],
            'vesting_rule' => ['required', 'string'],
            'vest_at_alt' => ['required', 'string'],
            'contracted_at_alt' => ['required', 'string'],
            'token_price' => ['required'],
        ]);

        $userid = $request->get('select-user');

        $now_price = u::getLastPrice($request->get('select_new_esop_symbol'));
        $quantity = (int)toEnglish($request->get('quantity'));
        $item = new StockEsops();
        $item->created_by = Auth()->id();
        $item->shareholder_id = StockShareholdersController::getByUserId($userid);
        $item->contracted_at = Carbon::createFromTimestamp($request->get('contracted_at_alt'))->toDateTimeString();
        $item->symbol_id = $request->get('select_new_esop_symbol');
        $item->tokens_quantity = $quantity;
        $item->token_price = toEnglish($request->get('token_price'));
        $item->esop_value = $quantity * toEnglish($request->get('token_price'));
        $item->vesting_rule = $request->get('vesting_rule');
        $item->will_vest_at = Carbon::createFromTimestamp($request->get('vest_at_alt'))->startOfDay()->toDateTimeString();
        $item->title = $request->get('title');
        $item->save();

        $user = User::find($userid);
        $user->notify(new newEsop($item->title));

        return redirect("/admin/stock/esops/$userid")->with('msg-ok', 'قرارداد افزوده شد');
    }
}

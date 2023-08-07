<?php

namespace Bslm\Stock\Http\Models;

use App\Models\User;
use Bslm\Stock\Http\Notifications\stockTrade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StockTrades extends Model
{
    public $table = 'stock_trades';

    public static function sendTradeMail($user, $tradeId, $count, $price, $sellerOrBuyer): void
    {
        $emailData = [
            'email' => $user->email_basalam ?? $user->email,
            'id' => $tradeId
        ];
        Mail::send(
            ['html' => $sellerOrBuyer == 'seller' ? 'mail.trade_seller' : 'mail.trade_buyer'],
            ['count' => toPersian($count), 'price' => toPersian($price), 'trade_id' => toPersian($tradeId)], function ($message) use ($emailData) {
            $message->to($emailData['email']);
            $message->subject("معامله سهام BSLM - شماره معامله: $emailData[id]");
            $message->from('info@basalamiha.com', 'Basalamiha');
        });
    }

    public static function trade($shareholder_id, $shareholder_id_receiver, $symbol_id, $quantity, $price, $trade_value, $bank_receipt,
                                 $descriptionSender, $descriptionReceiver, $smsTextSender, $smsTextReceiver, $isVest, $esopDetails = null,
                                 $seller = null, $buyer = null)
    {
        DB::beginTransaction();
        try {
            $sender = new StockTrades();
            $sender->created_by = auth()->id();
            $sender->shareholder_id = $shareholder_id;
            $sender->symbol_id = $symbol_id;
            $sender->tokens_quantity = $quantity * -1;
            $sender->token_price = $price;
            $sender->trade_value = $trade_value * -1;
            $sender->description = $descriptionSender;
            $sender->bank_receipt = $bank_receipt;
            $sender->save();
            $senderId = $sender->id;

            if ($isVest) {
                $receiver = new StockTrades();
                $receiver->created_by = auth()->id();
                $receiver->shareholder_id = $shareholder_id;
                $receiver->symbol_id = $symbol_id;
                $receiver->tokens_quantity = $quantity;
                $receiver->token_price = $price;
                $receiver->trade_value = $trade_value;
                $receiver->description = $descriptionReceiver;
                $receiver->bank_receipt = $bank_receipt;
                $receiver->mutual_trade_id = $senderId;
                $receiver->save();
                $receiverId = $receiver->id;

                $userReceiver = User::find(StockShareholders::select()->where('id', $shareholder_id_receiver)->first()->person_id);
                if ($userReceiver) {
                    $userReceiver->notify(new stockTrade($quantity, $symbol_id, $trade_value, null, $userReceiver));
                    $smsData = [
                        'to' => $userReceiver->mobile,
                        'text' => urlencode(toPersian($quantity) . $smsTextReceiver)
                    ];
                    sendSms($smsData['text'], $smsData['to']);
                }

                $esopDetails->vested_at = Carbon::now();
                $esopDetails->update();
            } else {
                if ($seller) {
                    self::notifyAndSms($seller, $quantity, $sender, $price, $senderId, 'seller');
                }
                // create shareholder if not exist
                $shareholder = StockShareholders::firstOrCreate(
                    ['person_id' => $shareholder_id_receiver],
                    [
                        'name' => $buyer->name,
                        'person_id' => $buyer->id
                    ]
                );

                $receiver = new StockTrades();
                $receiver->created_by = auth()->user()->id;
                $receiver->shareholder_id = $shareholder->id;
                $receiver->symbol_id = $symbol_id;
                $receiver->tokens_quantity = $quantity;
                $receiver->token_price = $price;
                $receiver->trade_value = $quantity * $price;
                $receiver->mutual_trade_id = $senderId;
                $receiver->description = $descriptionReceiver;
                $receiver->bank_receipt = $bank_receipt;
                $receiver->save();
                $receiverId = $receiver->id;

                if ($buyer) {
                    self::notifyAndSms($buyer, $quantity, $receiver, $price, $receiverId, 'buyer');
                }
            }

            $item = self::find($senderId);
            $item->mutual_trade_id = $receiverId;
            $item->update();

            DB::commit();
            if ($isVest) {
                return response()->json([
                    'data' => null,
                    'code' => 1,
                    'message' => 'ok',
                ]);
            } else {
                try {
                    self::sendTradeMail($sender, $senderId, $count, $price, 'seller');
                    self::sendTradeMail($receiver, $receiverId, $count, $price, 'buyer');
                } catch (\Throwable $exception) {
                    Log::warning('ارسال ایمیل با خطا مواجه شد! (vest esop)');
                }
                return redirect("/admin/stock/trades")->with('msg-ok', __('msg.trade_done'));
            }
        } catch (\Throwable $exception) {
            DB::rollback();
            if ($isVest) {
                return redirect("/admin/stock/esops")->with('msg-error', __('msg.vest_failed'));
            } else {
                return redirect("/admin/stock/trades")->with('msg-error', __('msg.trade_failed'));
            }
        }
    }

    protected static function notifyAndSms($user, $count, StockTrades $item, $price, $tradeId, $sellerOrBuyer): void
    {
        $user->notify(new stockTrade($count, $item->symbol_id, ($count * $price), $sellerOrBuyer == 'seller' ? $user : null, $sellerOrBuyer == 'buyer' ? $user : null));
        $smsData = [
            'to' => $user->mobile,
            'text' => ($sellerOrBuyer == 'buyer') ?
                urlencode(toPersian($count) . " مثقال سهام به قیمت هر مثقال " . toPersian($price) . " تومان خریدید. شماره معامله:‌ $tradeId") :
                urlencode(toPersian($count) . " مثقال سهام شما به قیمت هر مثقال " . toPersian($price) . " تومان فروخته شد. شماره معامله:‌ $tradeId")
        ];
        sendSms($smsData['text'], $smsData['to']);
    }
}

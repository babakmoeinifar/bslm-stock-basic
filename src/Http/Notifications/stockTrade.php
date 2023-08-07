<?php

namespace Bslm\Stock\Http\Notifications;

use Bslm\Stock\Http\Models\StockSymbols;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class stockTrade extends Notification implements ShouldQueue
{
    use Queueable;

    public $text;
    public $symbolName;

    public function __construct($tokenQuantity, $symbolId, $tradeValue, $sender = null, $receiver = null)
    {
        $this->symbolName = StockSymbols::where('id', $symbolId)->value('symbol_identifier');

        if ($sender) {
            $this->text = "{$tokenQuantity} مثقال از سهام {$this->symbolName} شما به ارزش ".number_format($tradeValue)." تومان فروخته شد.";
        } elseif ($receiver) {
            $this->text = "{$tokenQuantity} مثقال سهام {$this->symbolName} به ارزش ".number_format($tradeValue)." تومان خریدید.";
        }
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'text' => $this->text,
            'type' => 'stockTrade',
            'link' => "stock/dashboard",
        ];
    }
}

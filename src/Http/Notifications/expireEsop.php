<?php

namespace Bslm\Stock\Http\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class expireEsop extends Notification implements ShouldQueue
{
    use Queueable;

    public $text;

    public function __construct($stockEsopsTitle)
    {
        $this->text = "متاسفانه قرارداد {$stockEsopsTitle} شما منقضی شد.";

    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'text' => $this->text,
            'type' => 'expireEsop',
            'link' => "stock/dashboard",
        ];
    }
}

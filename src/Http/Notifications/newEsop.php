<?php

namespace Bslm\Stock\Http\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class newEsop extends Notification implements ShouldQueue
{
    use Queueable;

    public $text;

    public function __construct($stockEsopsTitle)
    {
        $this->text = "قرارداد {$stockEsopsTitle}  شما ثبت شد و امیدواریم محقق هم بشود.";

    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'text' => $this->text,
            'type' => 'newEsop',
            'link' => "stock/dashboard",
        ];
    }
}

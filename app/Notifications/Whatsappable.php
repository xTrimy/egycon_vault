<?php

namespace App\Notifications;

use App\Services\Whatsapp\WhatsappMessage;
use Illuminate\Notifications\Notifiable;

interface Whatsappable
{
    /**
     * Create telegram notification body
     *
     * @return WhatsappMessage
     */
    public function toWhatsapp($notifiable): WhatsappMessage;
}

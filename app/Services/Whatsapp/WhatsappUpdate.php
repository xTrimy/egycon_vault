<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Log;

class WhatsappUpdate{
    private $update;
    public $type;
    public $data;

    public function __construct($data){
        $this->update = $data;
        Log::channel('whatsapp')->info('Message Received: '. json_encode($data));
    }

    public function getNumber(){
        return @$this->update["from"];
    }

    public function getText()
    {
        return @$this->update["message"]["message"];
    }
}
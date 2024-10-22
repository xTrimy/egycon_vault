<?php

namespace App\Services\Whatsapp\WhatsappMessage;

class ActionUrl{
    public $text;
    public $url;
    
    public function toString(){
        return "{$this->text}: {$this->url}";
    }

    public function toArray(){
        return [
            'text' => $this->text,
            'url' => $this->url
        ];
    }
}
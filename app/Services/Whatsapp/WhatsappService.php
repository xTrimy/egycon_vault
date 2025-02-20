<?php

namespace App\Services\Whatsapp;

use App\Exceptions\UserNotFoundException;
use App\Models\Belonging;
use App\Models\BelongingWhatsappMessage;
use App\Models\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use stdClass;

class WhatsappService
{
    protected $API_KEY;
    private $url;
    private $phone;
    private $belonging_id;
    public function __construct($phone, $belonging_id = null)
    {
        $this->API_KEY = env('WHATSAPP_API_KEY');

        if ($phone == null) {
            throw new UserNotFoundException("Notifiable phone is not set!");
        }
        if (substr($phone, 0, 2) == '01') {
            $phone = "2{$phone}";
        } else if (substr($phone, 0, 2) == "+2") {
            $phone = substr($phone, 1);
        } else if (substr($phone, 0, 2) == '20') {
            // do nothing
        } else {
            throw new InvalidArgumentException("Invalid phone number");
        }
        $this->url = "https://waapi.app/api/v1/instances/{id}/client/";
        $instance_id = env('WHATSAPP_INSTANCE_ID');
        $this->url = str_replace("{id}", $instance_id, $this->url);
        $this->phone = $phone;
        $this->belonging_id = $belonging_id;
    }

    public function bot($method, $data = [])
    {
        if ($method != 'send-message' && $method != 'send-media') {
            throw new InvalidArgumentException("Invalid method: {$method}");
        }

        if ($this->belonging_id != null) {
            $WAmessage = new BelongingWhatsappMessage();
            $WAmessage->belonging_id = $this->belonging_id;
            $WAmessage->phone = $this->phone;
            $WAmessage->message = json_encode($data);
            $WAmessage->save();
        }
        $url = "{$this->url}";
        if (!config("app.enable_whatsapp_notifications")) {
            $this->log($data, $method);
            return $data;
        }
        $body = array(
            'chat_id' => $this->phone,
        );

        $body = array_merge($body, $data);

        $url .= "action/$method";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: */*', 'Authorization: Bearer ' . $this->API_KEY]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $res = curl_exec($ch);
        Log::info("WhatsappService: {$method} - {$this->phone} - result: " . $res);
        if (curl_error($ch)) {
            Log::error(curl_error($ch));
            if ($this->belonging_id != null) {
                $WAmessage->failed_at = now();
                $WAmessage->failure_reason = "Server Error";
                $WAmessage->save();
            }
            return curl_error($ch);
        } else {
            curl_close($ch);
            $info = curl_getinfo($ch);
            if ($info['http_code'] != 200) {
                $reason = "HTTP Code: {$info['http_code']}";
                try {
                    $reason_message = json_decode($res, true)['message'];
                    if ($reason_message) $reason = $reason_message;
                } catch (\Exception $e) {
                }
                if ($this->belonging_id != null) {
                    $WAmessage->failed_at = now();
                    $WAmessage->failure_reason = $reason;
                    $WAmessage->save();
                }
                Log::error("WhatsappService: {$method} - {$this->phone} - result: " . $res);
            }
            if ($this->belonging_id != null) {
                $WAmessage->is_sent = true;
                $WAmessage->sent_at = now();
                $WAmessage->save();
            }
            try {
                return json_decode($res, true);
            } catch (\Exception $e) {
                return $res;
            }
        }
    }



    public function sendMessage($text)
    {
        $data = array(
            'message' => $text
        );
        return $this->bot('send-message', $data);
    }

    public function sendImage($text, $media_url)
    {
        $data = array(
            "mediaUrl" => $media_url,
            'media_type' => 'image',
            'mediaCaption' => $text
        );
        return $this->bot('send-media', $data);
    }


    public function send(WhatsappMessage $message)
    {
        if ($message->hasImage()) {
            return $this->sendImage($message->toString(), $message->image);
        }
        return $this->sendMessage($message->toString());
    }

    private function log($data, $method)
    {
        Log::channel('whatsapp')->info(
            "Whatsapp Message Logged" .
                PHP_EOL .
                "Method: " . $method .
                PHP_EOL .
                "To: " . $this->phone .
                PHP_EOL .
                json_encode($data)
        );
    }

    public function getPhoneNumber()
    {
        return $this->phone;
    }
}

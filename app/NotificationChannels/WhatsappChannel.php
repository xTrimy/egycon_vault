<?php

namespace App\NotificationChannels;

use App\Models\Belonging;
use App\Notifications\Whatsappable;
use App\Services\Whatsapp\WhatsappService;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Support\Facades\Log;

/**
 * Class WhatsappChannel.
 */
class WhatsappChannel
{
    private $dispatcher;

    /**
     * Channel constructor.
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function send($notifiable, Whatsappable $notification): ?array
    {
        // @phpstan-ignore-next-line
        $message = $notification->toWhatsapp($notifiable);
        $belonging_id = null;
        if ($notifiable instanceof Belonging) {
            $belonging_id = $notifiable->id;
        }
        try {
            $whatsappService = new WhatsappService($notifiable->phone, $belonging_id);
        } catch (Exception $e) {
            $this->dispatcher->dispatch(new NotificationFailed(
                $notifiable,
                $notification,
                'whatsapp'
            ));
            dd($e);
            return null;
        }
        $response = $whatsappService->send($message);
        return $response instanceof Response ? json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR) : $response;
    }
}

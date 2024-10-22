<?php

namespace App\Notifications;

use App\Helpers\HttpHelper;
use App\Helpers\RequestsHelper;
use App\Helpers\StringUtils;
use App\Models\Belonging;
use App\Models\Post;
use App\Services\CardGenerator\CardGenerator;
use App\Services\Telegram\TelegramMessage;
use App\Services\Whatsapp\WhatsappMessage;
use Clockwork\Request\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log as FacadesLog;

class BelongingRegistered extends Notification implements Whatsappable, ShouldQueue
{
    use Queueable;
    private $belonging;
    private $event_name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Belonging $belonging)
    {
        $this->belonging = $belonging;
        $this->event_name = "EGYCON Halloween";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['whatsapp'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' => $this->belonging->id,
            'name' => $this->belonging->name,
        ];
    }

    public function toWhatsapp($notifiable): WhatsappMessage
    {
        $cardImagePath = CardGenerator::generateCard($this->belonging);
        $cardImageUrl = asset($cardImagePath);
        return (new WhatsappMessage)
            ->greeting('Hello, ' . explode(' ', $notifiable->name)[0])
            ->subject("We are pleased to be with you today at {$this->event_name}")
            ->line("\n")
            ->line('You have registered your belonging')
            ->separator()
            ->line("Your code is: " . $this->belonging->code)
            ->line("Please show this code to the event staff to retrieve your belonging.")
            ->separator()
            ->line("Your belonging details:")
            ->line('Name: ' . $this->belonging->name)
            ->line('Email: ' . $this->belonging->email)
            ->line('Phone: ' . $this->belonging->phone)
            ->line('Color: ' . $this->belonging->color_name)
            ->line('Date: ' . $this->belonging->created_at)
            ->separator()
            ->image($cardImageUrl)
            ->line("Powered by: Gamers Legacy")
            ->line("More info: https://glegacy.me");
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendAuthenticationMail extends Notification
{
    use Queueable;
    private $details;
    private $type;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($details,$type)
    {
        $this->details = $details;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * @param $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        switch ($this->type){
            case 1:
                return (new MailMessage)
                    ->greeting('Hello '.$this->details['name'])
                    ->subject($this->details['subject'])
                    ->line($this->details['line1'])
                    ->action($this->details['link_text'],$this->details['link']);
                break;
            case 2:
                return (new MailMessage)
                    ->greeting('Hello '.$this->details['name'])
                    ->subject($this->details['subject'])
                    ->line($this->details['line1'])
                    ->line($this->details['line2'])
                    ->line($this->details['last_line']);
                break;
            case 3:
                return (new MailMessage)
                    ->subject($this->details['subject'])
                    ->line($this->details['line1'])
                    ->line($this->details['line2'])
                    ->line($this->details['last_line']);
                break;
        }
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
            //
        ];
    }
}
